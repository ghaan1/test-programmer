import Alpine from "alpinejs";
import "../css/app.css";
import setupLogin from "./login";
import sidebar from "./sidebar";
import product from "./product";
import createProduct from "./createProduct.js";
import updateProduct from "./updateProduct.js";
import profilePage from "./profilePage.js";

window.Alpine = Alpine;

setupLogin();
Alpine.data("sidebar", sidebar);
Alpine.data("product", product);
Alpine.data("createProduct", createProduct);
Alpine.data("updateProduct", updateProduct);
Alpine.data("profilePage", profilePage);

Alpine.start();
