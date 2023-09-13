import React from 'react';

const Product = ({ product }) => {
    return (
        <div className='product'>
            <input type="checkbox" name="" id="" className='delete-checkbox'/>
            <span>{ product.sku }</span>
            <span>{ product.name }</span>
            <span>{ product.price } $</span>
            <span>{ product.description[0].attribute }: { product.description[0].value }</span>
        </div>
    );
};

export default Product;