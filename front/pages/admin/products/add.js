import LayoutAdmin from "../../../components/layout_admin"
import Head from 'next/head'
import {useState} from "react";
import {signIn} from "next-auth/client";
import { useRouter } from "next/router";



export async function getServerSideProps(context) {
    const productTypesResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/product-types`)
    const productTypes = await productTypesResponse.json()

    return {
        props: {
            productTypes,
        },
    }
}


export default function ProductAdd({productProp, productTypes,}) {

    async function handleSubmit(event) {
        event.preventDefault()

        const createResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/products`, {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })

        const result = await createResponse.json()

        setErrors(null)

        if (createResponse.status === 422) {
            setErrors(result.errors)
            return
        }

        if (!createResponse.ok) {
            setErrors({global: 'something went wrong'})
        }

        const ProductNo = result.ProductNo

        router.push({pathname: '/admin/products/[id]', query: {id: ProductNo}})
    }

    const router = useRouter();

    const [formData, setFormData] = useState({
        ProductNo: '',
        ProductTypeId: '',
        ProductName: '',
        ABV: '',
        Price: ''
    })
    const [errors, setErrors] = useState(null)

    function handleChange(e) {
        setFormData({...formData, [e.target.name]: e.target.value})
    }

    return (
        <LayoutAdmin>
            <Head>
                <title>Add Product</title>
            </Head>

            <h1>Add product</h1>

            <form onSubmit={handleSubmit}>

                <div className="text-danger">
                    {errors?.global}
                </div>

                <div className="mb-3">
                    <label htmlFor="ProductNo" className="form-label">ProductNo</label>
                    <input type="input" className="form-control" id="ProductNo" name="ProductNo" onChange={handleChange} value={formData.ProductNo}/>
                </div>
                <div className="text-danger">
                    {errors?.ProductNo}
                </div>

                <div className="mb-3">
                    <label htmlFor="ProductTypeId" className="form-label">ProductType</label>
                    <select className="form-select" value={formData.ProductTypeId} name="ProductTypeId" onChange={handleChange}>
                        <option value="">Choose type</option>
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

                <button type="submit" className="btn btn-primary mt-2">Add</button>
            </form>

        </LayoutAdmin>
    )
}
