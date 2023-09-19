class Product {
    constructor(sku, name, price) {
        this.sku = sku;
        this.name = name;
        this.price = price;
    }
    getAttribute() {
    }

    getValue() {
    }
}

class DVD extends Product {
    constructor(sku, name, price, size) {
        super(sku, name, price);
        this.size = size;
    }

    getAttribute() {
        return "Size";
    }

    getValue() {
        return `${this.size} MB`;
    }
}

class Book extends Product {
    constructor(sku, name, price, weight) {
        super(sku, name, price);
        this.weight = weight;
    }

    getAttribute() {
        return "Weight";
    }

    getValue() {
        return `${this.weight} KG`;
    }
}

class Furniture extends Product {
    constructor(sku, name, price, dimensions) {
        super(sku, name, price);
        this.dimensions = dimensions;
    }

    getAttribute() {
        return "Dimensions";
    }

    getValue() {
        const { height, width, length } = this.dimensions;
        return `${height}x${width}x${length}`;
    }
}

export { Product, DVD, Book, Furniture };