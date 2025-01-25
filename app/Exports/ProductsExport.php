<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Storage;

class ProductsExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $searchTerm;
    protected $category;

    public function __construct($searchTerm = null, $category = null)
    {
        $this->searchTerm = $searchTerm;
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Product::with('category');

        if ($this->searchTerm) {
            $query->where('name', 'ILIKE', '%' . $this->searchTerm . '%')
                ->orWhere('price', 'ILIKE', '%' . $this->searchTerm . '%')
                ->orWhere('selling_price', 'ILIKE', '%' . $this->searchTerm . '%')
                ->orWhere('stock', 'ILIKE', '%' . $this->searchTerm . '%');
        }

        if ($this->category) {
            $query->where('fk_product_category', $this->category);
        }

        return $query->get();
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category ? $product->category->name : 'N/A',
            $product->price,
            $product->selling_price,
            $product->stock,
            env('APP_URL') . Storage::url($product->image),
        ];
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Kategori Produk',
            'Harga Beli (Rp)',
            'Harga Jual (Rp)',
            'Stok Produk',
            'URL Gambar',
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1:G1')->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(40);

                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    for ($col = 'A'; $col <= 'G'; $col++) {
                        $cellCoordinate = $col . $row;
                        $cellValue = $sheet->getCell($cellCoordinate)->getValue();
                        $sheet->setCellValueExplicit($cellCoordinate, $cellValue, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    }
                }
            },
        ];
    }
}