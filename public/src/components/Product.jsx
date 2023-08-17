import React from 'react';

const Product = ({sku, name, price, additional}) => {
    return (
        <div className='product'>
            <input type="checkbox" name="" id="" className='delete-checkbox'/>
            <span>{ sku }</span>
            <span>{ name }</span>
            <span>{ price } $</span>
            
        </div>
    );
};

export default Product;