import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { apiCall } from '../utils/api.js';
import { DVD, Book, Furniture } from "../utils/ProductClasses";
import Footer from "../components/Footer";

const AddProduct = () => {
    const navigate = useNavigate();
    const [sku, setSKU] = useState('');
    const [name, setName] = useState('');
    const [price, setPrice] = useState('');
    const [type, setType] = useState('');
    const [size, setSize] = useState('');
    const [weight, setWeight] = useState('');
    const [height, setHeight] = useState('');
    const [width, setWidth] = useState('');
    const [length, setLength] = useState('');

    const saveProduct = async (event) => {
        event.preventDefault();

        let product;

        if (type === "dvd") {
            product = new DVD(sku, name, price, size);
        } else if (type === "book") {
            product = new Book(sku, name, price, weight);
        } else if (type === "furniture") {
            product = new Furniture(sku, name, price, { height, width, length });
        }

        const data = {
            sku: product.sku,
            name: product.name,
            price: product.price,
            attribute: product.getAttribute(),
            value: product.getValue()
        };

        apiCall('addProduct', 'POST', data)
            .then(response => {
                if (response) {
                    setSKU("");
                    setName("");
                    setPrice("");
                    setType("");
                    setSize("");
                    setWeight("");
                    setHeight("");
                    setWidth("");
                    setLength("");
                    navigate('/');
                } else {
                    console.log(response.message);
                }
            })
            .catch(error => {
                console.log(error);
            });
    };

    const handlePriceChange = (event) => {
        let inputValue = event.target.value;
        inputValue = inputValue.replace(/[^\d]/g, '');
        const length = inputValue.length;

        if (length > 2) {
            inputValue = inputValue.slice(0, length - 2) + '.' + inputValue.slice(length - 2);
        }

        if (inputValue !== '' && !isNaN(inputValue)) {
            event.target.value = inputValue;
            setPrice(inputValue);
        } else {
            setPrice('');
        }
    };

    return (
        <>
            <form id="product_form" onSubmit={(event) => saveProduct(event)} className="container">
                <div className="header">
                    <h1>Product Add</h1>
                    <div className="header__buttons">
                        <button type="submit">Save</button>
                        <button onClick={() => navigate('/')}>Cancel</button>
                    </div>
                </div>
                <div className="content form">
                    <div className="form__input-wrapper">
                        <label htmlFor="sku">SKU</label>
                        <input id="sku"
                            type="text"
                            value={sku}
                            onChange={(e) => setSKU(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form__input-wrapper">
                        <label htmlFor="name">Name</label>
                        <input id="name"
                            type="text"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form__input-wrapper">
                        <label htmlFor="price">Price ($)</label>
                        <input id="price"
                            type="text"
                            value={price}
                            onChange={(e) => handlePriceChange(e)}
                            required
                        />
                    </div>
                    <div className="form__input-wrapper">
                        <label htmlFor="productType">Type Switcher</label>
                        <select id="productType"
                            value={type}
                            onChange={(e) => setType(e.target.value)}
                            required
                        >
                            <option value="">Select product type</option>
                            <option value="dvd">DVD</option>
                            <option value="book">Book</option>
                            <option value="furniture">Furniture</option>
                        </select>
                    </div>
                    {type === "dvd" && (
                        <>
                            <h2>Please, provide size</h2>
                            <div className="form__input-wrapper">
                                <label htmlFor="size">Size (MB)</label>
                                <input
                                    id="size"
                                    type="number"
                                    value={size}
                                    onChange={(e) => setSize(e.target.value)}
                                    required
                                />
                            </div>
                        </>
                    )}

                    {type === "book" && (
                        <>
                            <h2>Please, provide weight</h2>
                            <div className="form__input-wrapper">
                                <label htmlFor="weight">Weight (KG)</label>
                                <input
                                    id="weight"
                                    type="number"
                                    value={weight}
                                    onChange={(e) => setWeight(e.target.value)}
                                    required
                                />
                            </div>
                        </>
                    )}

                    {type === "furniture" && (
                        <>
                            <h2>Please, provide dimensions</h2>
                            <div className="form__input-wrapper">
                                <label htmlFor="height">Height (CM)</label>
                                <input
                                    id="height"
                                    type="number"
                                    value={height}
                                    onChange={(e) => setHeight(e.target.value)}
                                    required
                                />
                            </div>
                            <div className="form__input-wrapper">
                                <label htmlFor="width">Width (CM)</label>
                                <input
                                    id="width"
                                    type="number"
                                    value={width}
                                    onChange={(e) => setWidth(e.target.value)}
                                    required
                                />
                            </div>
                            <div className="form__input-wrapper">
                                <label htmlFor="length">Length (CM)</label>
                                <input
                                    id="length"
                                    type="number"
                                    value={length}
                                    onChange={(e) => setLength(e.target.value)}
                                    required
                                />
                            </div>
                        </>
                    )}
                </div>
                <Footer />
            </form>
        </>
    );
};

export default AddProduct;