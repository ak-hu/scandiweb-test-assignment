import { useState, useEffect } from 'react';
import { useNavigate } from "react-router-dom";

import Footer from '../components/Footer';
import Product from '../components/Product';


const ProductList = () => {
    const navigate = useNavigate();
    const [products, setProducts] = useState([]);
    const addProduct = () => {
        navigate('/add-product')
    }
    
    useEffect(() => {
        fetch('http://localhost:8888/scandidev/server/api.php?endpoint=getProducts')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                setProducts(data);
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }, []);

    console.log(products)

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
                {products.map((product) => <Product key={product.id} product={product} />
                )}
            </div>
            <Footer />
        </div>
    );
};

export default ProductList;