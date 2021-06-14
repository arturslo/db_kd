import Head from 'next/head'
import Layout from '../components/layout'
import {useState} from "react";


export async function getServerSideProps(context) {
    const productsResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/products`)
    const products = await productsResponse.json()

    const productTypesResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/product-types`)
    const productTypes = await productTypesResponse.json()


    return {
        props: {
            propProducts: products,
            productTypes,
        },
    }
}

export default function Home({propProducts, productTypes}) {
    const [products, setProducts] = useState(propProducts)
    const [ProductTypeId, setProductTypeId] = useState('')

    async function onSelectChange(event) {
        const ProductTypeId = event.target.value;
        setProductTypeId(ProductTypeId)

        const productsResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/products?ProductTypeId=${ProductTypeId}`)
        const products = await productsResponse.json()
        setProducts(products)
    }

    return (
        <Layout>
            <Head>
                <title>Shop</title>
            </Head>

            <section className="py-5 text-center container">
                <div className="row py-lg-5">
                    <div className="col-lg-6 col-md-8 mx-auto">
                        <h1 className="fw-light">Shop</h1>
                        <p className="lead text-muted">Best drink shop</p>
                    </div>
                </div>
            </section>

            <section className="py-5 text-center container">
                <div className="row py-lg-5">
                    <select className="form-select" value={ProductTypeId} onChange={onSelectChange}>
                        <option value="">All</option>
                        {productTypes.map(productType => {
                            return <option key={productType.ProductTypeId} value={ productType.ProductTypeId }>{productType.Name}</option>
                        })}
                    </select>
                </div>
            </section>

            <div className="py-5 bg-light">
                <div className="container">

                    <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        {products.map(product => {
                            return (<div key={product.ProductNo} className="col">
                                <div className="card shadow-sm">
                                    <svg className="bd-placeholder-img card-img-top" width="100%" height="225"
                                         xmlns="http://www.w3.org/2000/svg" role="img"
                                         aria-label="Placeholder: Thumbnail"
                                         preserveAspectRatio="xMidYMid slice" focusable="false">
                                        <title>Placeholder</title>
                                        <rect width="100%" height="100%" fill="#55595c"/>
                                        <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                                    </svg>

                                    <div className="card-body">
                                        <p className="card-text">{product.ProductName}</p>
                                        <p className="card-text">Type: {product.ProductType.Name}</p>
                                        <p className="card-text">ABV: {product.ABV}</p>
                                        <p className="card-text">Price: {product.Price}</p>
                                        <div className="d-flex justify-content-between align-items-center">
                                            <div className="btn-group">
                                                <button type="button" className="btn btn-sm btn-outline-secondary">Buy
                                                </button>
                                            </div>
                                            <small className="text-muted">{product.InStock} in stock</small>
                                        </div>
                                    </div>
                                </div>
                            </div>)
                        })}
                    </div>

                </div>
            </div>

        </Layout>
    )
}
