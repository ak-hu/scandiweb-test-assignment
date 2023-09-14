import { useState, useEffect } from 'react';
import { useNavigate } from "react-router-dom";
import axios from 'axios';

import Footer from '../components/Footer';
import Product from '../components/Product';


const ProductList = () => {
    const navigate = useNavigate();
    const [products, setProducts] = useState([]);
    const [selectedProducts, setSelectedProducts] = useState([]);

    const handleMassDelete = () => {
        axios.post('http://localhost:8888/scandidev/server/api.php?endpoint=massDeleteProducts', {
            productIds: selectedProducts,
        })
        .then(response => {
            if (response.status === 200) {
                const updatedProducts = products.filter(product => !selectedProducts.includes(product.id));
                setProducts(updatedProducts);
                setSelectedProducts([]);
            }
        })
        .catch(error => {
            console.error('Axios error:', error);
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
        axios.get('http://localhost:8888/scandidev/server/api.php?endpoint=getProducts')
        .then(response => {
            if (response.status === 200) {
                setProducts(response.data);
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .catch(error => {
            console.error('Axios error:', error);
        });
    }, []);

    return (
        <div className='container'>
            <div className='header'>
                <h1>Product List</h1>
                <div className='header--buttons'>
                    <button onClick={() => navigate('/add-product')}>add</button>
                    <button onClick={handleMassDelete}>mass delete</button>
                </div>
            </div>
            <div className='content products-container'>
                {products.map((product) => <Product key={product.id} product={product} onCheckboxChange={handleCheckboxChange}/>
                )}
            </div>
            <Footer />
        </div>
    );
};

export default ProductList;