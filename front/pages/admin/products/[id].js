import LayoutAdmin from "../../../components/layout_admin"
import Head from 'next/head'
import {useState} from "react";
import {signIn} from "next-auth/client";
import { useRouter } from "next/router";



export async function getServerSideProps(context) {
    const ProductNo = context.params.id
    const productResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/products/${ProductNo}`)
    const product = await productResponse.json()

    const productTypesResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/product-types`)
    const productTypes = await productTypesResponse.json()

    return {
        props: {
            productProp: product,
            productTypes,
        },
    }
}


export default function ProductEdit({productProp, productTypes,}) {

    async function handleSubmit(event) {
        event.preventDefault()

        const ProductNo = query.id

        const updateResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/products/${ProductNo}`, {
            method: 'put',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })

        const result = await updateResponse.json()

        setErrors(null)

        if (updateResponse.status === 422) {
            setErrors(result.errors)
            return
        }

        if (!updateResponse.ok) {
            setErrors({global: 'something went wrong'})
        }

    }

    const { query } = useRouter();

    const [formData, setFormData] = useState({
        ProductTypeId: productProp.ProductTypeId,
        ProductName: productProp.ProductName,
        ABV: productProp.ABV,
        Price: productProp.Price
    })
    const [errors, setErrors] = useState(null)

    function handleChange(e) {
        setFormData({...formData, [e.target.name]: e.target.value})
    }

    return (
        <LayoutAdmin>
            <Head>
                <title>Edit Product</title>
            </Head>

            <h1>Edit product</h1>

            <form onSubmit={handleSubmit}>

                <div className="text-danger">
                    {errors?.global}
                </div>

                <div className="mb-3">
                    <label htmlFor="ProductTypeId" className="form-label">ProductType</label>
                    <select className="form-select" value={formData.ProductTypeId} name="ProductTypeId" onChange={handleChange}>
                        <option value="">All</option>
                        {productTypes.map(productType => {
                            return <option key={productType.ProductTypeId} value={ productType.ProductTypeId }>{productType.Name}</option>
                        })}
                    </select>
                </div>
                <div className="text-danger">
                    {errors?.ProductTypeId}
                </div>


                <div className="mb-3">
                    <label htmlFor="ProductName" className="form-label">ProductName</label>
                    <input type="input" className="form-control" id="ProductName" name="ProductName" onChange={handleChange} value={formData.ProductName}/>
                </div>
                <div className="text-danger">
                    {errors?.ProductName}
                </div>

                <div className="mb-3">
                    <label htmlFor="ABV" className="form-label">ABV</label>
                    <input type="input" className="form-control" id="ABV" name="ABV" onChange={handleChange} value={formData.ABV}/>
                </div>
                <div className="text-danger">
                    {errors?.ABV}
                </div>

                <div className="mb-3">
                    <label htmlFor="Price" className="form-label">Price</label>
                    <input type="Price" className="form-control" id="Price" name="Price" onChange={handleChange} value={formData.Price}/>
                </div>
                <div className="text-danger">
                    {errors?.Price}
                </div>

                <button type="submit" className="btn btn-primary mt-2">Update</button>
            </form>

        </LayoutAdmin>
    )
}
