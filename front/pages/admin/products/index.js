import LayoutAdmin from "../../../components/layout_admin"
import Head from 'next/head'
import Link from "next/link"
import {useState} from "react";
import {useRouter} from "next/router";

export async function getServerSideProps(context) {
    const productsResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/products`)
    const products = await productsResponse.json()

    return {
        props: {
            products,
        },
    }
}

export default function Products({products}) {

    async function handleDelete(product) {

        const deleteResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/products/${product.ProductNo}`, {
            method: 'delete',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
        })

        const result = await deleteResponse.json()

        setErrors(null)

        if (deleteResponse.status === 422) {
            setErrors(result.errors)
            return
        }

        if (!deleteResponse.ok) {
            setErrors({global: 'something went wrong'})
        }


        router.push({pathname: '/admin/products'})
    }

    const [errors, setErrors] = useState(null)
    const router = useRouter();

    return (
        <LayoutAdmin>
            <Head>
                <title>Products</title>
            </Head>

            <h1>Products</h1>

            <Link href="/admin/products/add">
                <button className="btn btn-primary">Add product</button>
            </Link>

            <div className="text-danger">
                {errors?.global}
            </div>

            <table className="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>ABV</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                {products.map(product => {
                    return (
                        <tr key={product.ProductNo}>
                            <td>{product.ProductNo}</td>
                            <td>{product.ProductName}</td>
                            <td>{product.ProductType.Name}</td>
                            <td>{product.Price}</td>
                            <td>{product.ABV}</td>
                            <td>
                                <Link href={{pathname: '/admin/products/[id]', query: {id: product.ProductNo}}}>
                                    <a>Edit</a>
                                </Link>
                            </td>
                            <td>
                                {product.RelatedRows.Total === 0 &&
                                    <button className="btn btn-primary" onClick={(e) => handleDelete(product, e)}>Delete</button>
                                }

                            </td>
                        </tr>
                    )
                })}
                </tbody>
            </table>

        </LayoutAdmin>
    )
}
