import { useState, useEffect } from 'react';
import { useNavigate } from "react-router-dom";

import { apiCall } from '../utils/api.js';
import Footer from '../components/Footer';
import Product from '../components/Product';

const ProductList = () => {
    const navigate = useNavigate();
    const [products, setProducts] = useState([]);
    const [selectedProducts, setSelectedProducts] = useState([]);

    const handleMassDelete = () => {
        apiCall('massDeleteProducts', 'POST', { productIds: selectedProducts })
            .then(response => {
                if (response && response.message) {
                    setProducts(prevProducts =>
                        prevProducts.filter(product => !selectedProducts.includes(product.id))
                    );
                    setSelectedProducts([]);
                } else {
                    console.log(response.message);
                }
            })
            .catch(error => {
                console.log(error)
            });
    }

    const handleCheckboxChange = (productId, isChecked) => {
        if (isChecked) {
            setSelectedProducts([...selectedProducts, productId]);
        } else {
            setSelectedProducts(selectedProducts.filter(id => id !== productId));
        }
    }

    useEffect(() => {
        apiCall('getProducts', 'GET')
            .then(response => {
                if (response) {
                    setProducts(response);
                } else {
                    console.log(response.message);
                }
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    return (
        <>
            <div className='container'>
                <div className='header'>
                    <h1>Product List</h1>
                    <div className='header__buttons'>
                        <button onClick={() => navigate('/add-product')}>ADD</button>
                        <button id='delete-product-btn' onClick={handleMassDelete}>MASS DELETE</button>
                    </div>
                </div>
                <div className='content product-list__wrapper'>
                    {products.map((product) => <Product key={product.id} product={product} onCheckboxChange={handleCheckboxChange} />
                    )}
                </div>
                <Footer />
            </div>
        </>
    );
};

export default ProductList;