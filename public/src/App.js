import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

import ProductList from "./pages/ProductList";
import AddProduct from "./pages/AddProduct";

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/add-product" element={<AddProduct />} />
        <Route path="/" element={<ProductList />} />
      </Routes>
    </BrowserRouter>
  );
}