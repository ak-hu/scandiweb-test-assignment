import { useState } from "react";
import { useNavigate } from "react-router-dom";

import Footer from "../components/Footer";

const AddProduct = () => {
    const navigate = useNavigate('');
    const [sku, setSKU] = useState('');
    const [name, setName] = useState('');
    const [price, setPrice] = useState('');
    const [type, setType] = useState('');

    // DVD additional field
    const [size, setSize] = useState('');

    // Book additional field
    const [weight, setWeight] = useState('');

    // Furniture additional fields
    const [height, setHeight] = useState('');
    const [width, setWidth] = useState('');
    const [length, setLength] = useState('');

    const saveProduct = async (event) => {
        event.preventDefault();

        const data = {
            sku,
            name,
            price,
        };

        if (type === "dvd") {
            data.attribute = "Size";
            data.value = size + " MB";
        } else if (type === "book") {
            data.attribute = "Weight";
            data.value = weight + " Kg";
        } else if (type === "furniture") {
            data.attribute = "Dimension";
            data.value = `${height}x${width}x${length} CM`;
        }

        try {
            console.log(data)
            const response = await fetch("http://localhost:8888/scandidev/server/api.php?endpoint=addProduct", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error("Network response was not ok");
            }

            // Если запрос успешен, очищаем поля формы
            setSKU("");
            setName("");
            setPrice("");
            setType("");
            setSize("");
            setWeight("");
            setHeight("");
            setWidth("");
            setLength("");

            navigate("/"); 
            console.log("Product added successfully!");
        } catch (error) {
            console.error("Fetch error:", error);
        }
    };

    const handlePriceChange = (event) => {
        const inputValue = event.target.value;
        // Проверяем, что введено числовое значение
        if (inputValue && !isNaN(inputValue)) {
            // Преобразуем значение в число и форматируем с двумя десятичными знаками
            const formattedValue = parseFloat(inputValue).toFixed(2);
            setPrice(formattedValue);
        }
    };

    return (
        <div className="container">
            <form action="post" id="product_form" onSubmit={(event) => saveProduct(event)}>
                <div className="header">
                    <h1>Product Add</h1>
                    <div className="header--buttons">
                        <button type="submit">Save</button>
                        <button>Cancel</button>
                    </div>
                </div>
                <div className="content form">
                    <div className="input-wrapper">
                        <label htmlFor="sku">SKU</label>
                        <input id="sku"
                            type="text"
                            value={sku}
                            onChange={(e) => setSKU(e.target.value)}
                            required
                        />
                    </div>
                    <div className="input-wrapper">
                        <label htmlFor="name">Name</label>
                        <input id="name"
                            type="text"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            required
                        />
                    </div>
                    <div className="input-wrapper">
                        <label htmlFor="price">Price ($)</label>
                        <input id="price"
                            type="text"
                            step="0.01"
                            value={price}
                            onChange={(event) => handlePriceChange(event)}
                            required
                        />
                    </div>
                    <div className="input-wrapper">
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
                    {type && (
                        <h2>Product description</h2>
                    )}

                    {type === "dvd" && (
                        <div className="input-wrapper">
                            <label htmlFor="size">Size (MB)</label>
                            <input
                                id="size"
                                type="number"
                                value={size}
                                onChange={(e) => setSize(e.target.value)}
                                required
                            />
                        </div>
                    )}

                    {type === "book" && (
                        <div className="input-wrapper">
                            <label htmlFor="weight">Weight (KG)</label>
                            <input
                                id="weight"
                                type="number"
                                value={weight}
                                onChange={(e) => setWeight(e.target.value)}
                                required
                            />
                        </div>
                    )}

                    {type === "furniture" && (
                        <>
                            <div className="input-wrapper">
                                <label htmlFor="height">Height (CM)</label>
                                <input
                                    id="height"
                                    type="number"
                                    value={height}
                                    onChange={(e) => setHeight(e.target.value)}
                                    required
                                />
                            </div>
                            <div className="input-wrapper">
                                <label htmlFor="width">Width (CM)</label>
                                <input
                                    id="width"
                                    type="number"
                                    value={width}
                                    onChange={(e) => setWidth(e.target.value)}
                                    required
                                />
                            </div>
                            <div className="input-wrapper">
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
            </form>
            <Footer />
        </div>
    );
};

export default AddProduct;