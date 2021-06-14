import Head from "next/head";
import Link from "next/link";

export default function LayoutAdmin({children}) {
    return (
        <>
            <Head>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
            </Head>

            <nav className="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div className="container-fluid">
                    <a href="#" className="navbar-brand d-flex align-items-center">
                        <strong>SHOP</strong>
                    </a>
                </div>
            </nav>

            <div className="d-flex" id="wrapper">

                <div className="border-end bg-white" id="sidebar-wrapper">
                    <div className="list-group list-group-flush">
                        <a className="list-group-item list-group-item-action list-group-item-light p-3"
                           href="#!">Users</a>
                        <a className="list-group-item list-group-item-action list-group-item-light p-3"
                           href="#!">Clients</a>
                        <Link href="/admin/products">
                            <a className="list-group-item list-group-item-action list-group-item-light p-3">Products</a>
                        </Link>
                        <a className="list-group-item list-group-item-action list-group-item-light p-3"
                           href="#!">Warehouse</a>
                        <a className="list-group-item list-group-item-action list-group-item-light p-3"
                           href="#!">Orders</a>
                        <a className="list-group-item list-group-item-action list-group-item-light p-3"
                           href="#!">Reports</a>
                    </div>
                </div>

                <div id="page-content-wrapper">

                    <main className="container-fluid">
                        {children}
                    </main>
                </div>

            </div>

        </>
    )
}
