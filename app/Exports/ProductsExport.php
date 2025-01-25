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
            number_format($product->price, 0, ',', '.'),
            number_format($product->selling_price, 0, ',', '.'),
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
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(40);
            },
        ];
    }
}