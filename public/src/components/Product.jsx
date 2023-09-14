import React from 'react';

const Product = ({ product, onCheckboxChange }) => {
    const handleCheckboxChange = (event) => {
        const productId = event.target.id;
        onCheckboxChange(productId, event.target.checked);
    }
    
    return (
        <div className='product'>
            <input type="checkbox" name="" id={product.id} className='delete-checkbox'
            onChange={handleCheckboxChange} />
            <span>{ product.sku }</span>
            <span>{ product.name }</span>
            <span>{ product.price } $</span>
            <span>{ product.description[0].attribute }: { product.description[0].value }</span>
        </div>
    );
};

export default Product;