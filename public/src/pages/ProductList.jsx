import React from 'react';
import { useNavigate } from "react-router-dom";

import Footer from '../components/Footer';
import Product from '../components/Product';
import products from '../data.json'


const ProductList = () => {
    const navigate = useNavigate();
    const addProduct = () => {
        navigate('/add-product')
    }

    return (
        <div className='container'>
            <div className='header'>
                <h1>Product List</h1>
                <div className='header--buttons'>
                    <button onClick={() => addProduct()}>add</button>
                    <button>mass delete</button>
                </div>
            </div>
            <div className='content products-container'>
                {products.map((product) => <Product sku={product.sku} name={product.name} price={product.price} description={product.description} />
                )}
            </div>
            <Footer />
        </div>
    );
};

export default ProductList;