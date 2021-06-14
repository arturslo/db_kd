import LayoutAdmin from "../../components/layout_admin"
import Head from 'next/head'


export default function Admin({children}) {
    return (
        <LayoutAdmin>
            <Head>
                <title>Admin Panel</title>
            </Head>
        </LayoutAdmin>
    )
}
