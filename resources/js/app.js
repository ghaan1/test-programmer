// resources/js/app.js
import Alpine from "alpinejs";
import "../css/app.css";
import setupLogin from "./login";
import sidebar from "./sidebar";
import product from "./product"; // Pastikan product.js sudah diimport dengan benar//
// import axios

window.Alpine = Alpine;

setupLogin();
Alpine.data("sidebar", sidebar);
Alpine.data("product", product); // Tambahkan Alpine data untuk product

Alpine.start();
