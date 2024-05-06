import React, { Component } from "react";
import ReactDOM from "react-dom/client";
import Swal from "sweetalert2";
import { ICategory } from "../interfaces/category.interface";
import { IProduct } from "../interfaces/product.interface";
import httpService from '../services/http.service';
import { currencyFormat, usd_money_format } from "../utils";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { isFullScreen, toogleFullScreen } from "../fullscreen";
import { ICustomer } from "../interfaces/customer.interface";
import { Modal } from "bootstrap";
import { ITable } from "../interfaces/table.interface";

interface ICartItem extends IProduct {
    quantity: number
}

type Props = {
    tax: number,
    delivery: number,
    discount: number,
};

type State = {
    categories: ICategory[],
    products: IProduct[],
    customers: ICustomer[],
    customer: ICustomer | undefined,
    tables: ITable[],
    table: ITable | undefined,
    customerName: string | null,
    customerEmail: string | null,
    customerMobile: string | null,
    cart: ICartItem[],
    showProducts: boolean,
    categoryName: string | null,
    total: number,
    subtotal: number,
    tax: number,
    deliveryCharge: number,
    discount: number,
    discountPercentage: number | undefined,
    tenderAmount: number,
    searchValue: string | null,
    remarks: string | null,
    isFullScreen: boolean,
    isLoading: boolean,
    isLoadingCategories: boolean,
    exchangeRate: number,
}



class PointOfSale extends Component<Props, State> {

    constructor(props: Props) {
        super(props);

        this.state = {
            categories: [],
            products: [],
            cart: [],
            customers: [],
            customer: undefined,
            tables: [],
            table: undefined,
            customerName: null,
            customerEmail: null,
            customerMobile: null,
            showProducts: false,
            categoryName: null,
            subtotal: 0,
            total: 0,
            tax: this.props.tax,
            deliveryCharge: this.props.delivery,
            discount: 0,
            discountPercentage: 0,
            searchValue: null,
            remarks: null,
            isFullScreen: isFullScreen(),
            tenderAmount: 0,
            isLoading: false,
            isLoadingCategories: true,
            exchangeRate: 0,
        };
    }
    componentDidMount() {
        this.getCategories();
        this.getTables();
        this.calculateTotal();
        this.getExchangeRate();
        this.setState({ tenderAmount: this.state.total });
        window.onbeforeunload = (event) => {
            return 'Are you really want to perform the action?';
        }
    }
    getExchangeRate = (): void => {
        httpService.get(`https://the-bruvs.net/api/v1/exchange-rate`)
            .then((response: any) => {
                this.setState({ exchangeRate: response.data.data });
            });
    }
    getCategories = (): void => {
        httpService.get(`https://the-bruvs.net/api/v1/pos/categories/items?access_token=$2a$12$ouKUJlDrvBJDYAmUgpxFK.JcyXLj4Tq9Y1xPtX.nOm.I./Xyt.aOq`)
            .then((response: any) => {
                this.setState({ categories: response.data.data });
            }).finally(() => {
                this.setState({ isLoadingCategories: false });
            });
    }
    getTables = (): void => {
        httpService.get(`/inventory/tables`).then((response: any) => {
            this.setState({ tables: response.data.data });
        }).finally(() => {

        });
    }
    handleTableClick = (table: ITable): void => {
        this.setState({ table: table });
    }
    handleDeselectClick = (): void => {
        this.setState({ table: undefined });
    }


    storeOrder = (): void => {
        if (this.state.cart.length == 0) {
            toast.error("Cart is empty");
            return;
        }
        this.setState({ isLoading: true });
        httpService.post(`/order`, {
            customer: this.state.customer,
            table: this.state.table,
            cart: this.state.cart,
            subtotal: this.state.subtotal,
            total: this.state.total,
            tax_rate: this.state.tax,
            delivery_charge: this.state.deliveryCharge,
            discount: this.state.discount,
            remarks: this.state.remarks,
            tender_amount: this.state.tenderAmount,
            change: this.getChangeAmount(),
        }).then((response: any) => {
            if (response.data) {
                this.printInvoice(response.data);
                this.resetPos();
                toast.info("The order has been placed");
                this.closeModal('checkoutModal');
            }
        }).finally(() => {
            this.setState({ isLoading: false });
        });
    }
    reset = (): void => {
        Swal.fire({
            title: 'Reset?',
            text: "Any unsaved changes will be lost",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Reset'
        }).then((result) => {
            if (result.isConfirmed) {
                this.resetPos();
            }
        });
    }
    
    resetPos = (): void => {
        this.setState({ products: [] });
        this.setState({ cart: [] });
        this.setState({ customers: [] });
        this.setState({ customer: undefined });
        this.setState({ customerName: null });
        this.setState({ customerEmail: null });
        this.setState({ customerMobile: null });
        this.setState({ showProducts: false });
        this.setState({ categoryName: "" });
        this.setState({ subtotal: 0 });
        this.setState({ deliveryCharge: this.props.delivery });
        this.setState({ total: 0 });
        this.setState({ discount: 0 });
        this.setState({ discountPercentage: 0});
        this.setState({ tax: this.props.tax });
        this.setState({ searchValue: null });
        this.setState({ remarks: null });
        this.setState({ tenderAmount: 0 });
        this.setState({ isLoading: false });
    }

    categoryClick = (category: ICategory): void => {
        this.setState({ showProducts: true });
        this.setState({ products: category.products || [] });
        this.setState({ categoryName: category.name });
    };
    backClick = (): void => {
        this.setState({ showProducts: false });
        this.setState({ products: [] });
        this.setState({ categoryName: "" });
    };
    updateItemQuantity = (event: React.ChangeEvent<HTMLInputElement>, item: ICartItem): void => {
        var value = Number(event.target.value);
        if (value <= 0) return;
        let cartItems = this.state.cart;
        let _prod = this.state.cart.find((p) => p.id === item.id);
        if (_prod) {
            _prod.quantity = value;
        }
        this.setState({ cart: cartItems }, () => {
            this.calculateTotal();
        });
    };

    toggleFullScreen = (): void => {
        toogleFullScreen();
        this.setState({ isFullScreen: !this.state.isFullScreen });
    };
    goToDashboard = (): void => {
        window.location.href = "/";
    };
    calculateTotal = (): void => {
        let _total: number = 0;
        let _subtotal: number = 0;
        if (this.state.cart.length > 0) {
            this.state.cart.map((item: ICartItem) => {
                _subtotal += item.price * item.quantity;
            });
        }
        let taxValue: number = 0;
        // if (this.state.tax > 0 && this.state.tax <= 100) {
        //     taxValue = ((this.state.tax * _subtotal) / 100)
        // }
        var discountPercentage = this.state.discountPercentage || 0;
        var value = Number((discountPercentage* _subtotal) / 100);
        this.setState({ discount: Number(value) });
        _total = Math.round(_subtotal) + Math.round(taxValue) + Math.round(this.state.deliveryCharge) - Math.round(value);
        this.setState({ subtotal: _subtotal });
        this.setState({ total: _total });
        this.setState({ tenderAmount: _total });
    };
    getTotalUsd = (): number =>{
        return Number(this.state.total / this.state.exchangeRate);
    }

    getTotalTax = (): number => {
        let taxValue = 0;
        if (this.state.tax > 0 && this.state.tax <= 100) {
            taxValue = ((this.state.tax * this.state.subtotal) / 100)
        }
        return taxValue;
    };
    getChangeAmount = (): number => {
        // if (this.state.tenderAmount <= this.state.total) {
        //     return 0;
        // }
        return this.state.tenderAmount - this.state.total;
    };
    handleTenderAmountChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ tenderAmount: Number(event.currentTarget.value) });
    };
    handleRemarksChange = (event: React.FormEvent<HTMLTextAreaElement>): void => {
        this.setState({ remarks: event.currentTarget.value });
    };
    removeItem = (item: ICartItem): void => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6473f4',
            cancelButtonColor: '#d93025',
            confirmButtonText: 'Remove'
        }).then((result) => {
            if (result.isConfirmed) {
                let newCartItems = this.state.cart.filter(i => i.id != item.id);
                this.setState({ cart: newCartItems }, () => this.calculateTotal());
            }
        });
    };
    addToCart = (product: IProduct): void => {
        let itemExists = this.state.cart.some(item => item.id === product.id);
        if (itemExists) {
            let cartItems = this.state.cart;
            let _prod = this.state.cart.find((p) => p.id === product.id);
            if (_prod) {
                _prod.quantity += 1;
            }
            this.setState({ cart: cartItems }, () => {
                this.calculateTotal();
            });
        } else {
            let cartItem: ICartItem = {
                id: product.id,
                name: product.name,
                image_url: product.image_url,
                price: product.price,
                cost: product.cost,
                barcode: product.barcode,
                sku: product.sku,
                ingredients: product.ingredients,
                quantity: 1,
            }
            this.setState({ cart: [cartItem, ...this.state.cart] }, () => {
                this.calculateTotal();
            });
        }
        //toast.info("Added to cart.");
        new Audio("/audio/public_audio_ding.mp3").play();
    };

    handleSearchSubmit = (event: React.FormEvent<HTMLFormElement>): void => {
        event.preventDefault();
        let search = this.state.searchValue;
        if (!search) return;
        let searchValue = search.toLowerCase().trim();
        let productFound = false;
        this.state.categories.map((category: ICategory) => {
            let _prod = category.products.find((p) => p.name.toLowerCase().includes(searchValue) || p?.barcode?.toLowerCase() == searchValue || p?.sku?.toLowerCase() == searchValue);
            if (_prod) {
                this.addToCart(_prod);
                productFound = true;
                return;
            }
        });
        if (!productFound) {
            toast.error("Product not found");
        }
    };
    handleSearchChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ searchValue: event.currentTarget.value });
    };

    handleCustomerSearchChange = (event: React.FormEvent<HTMLInputElement>): void => {
        var searchQuery = event.currentTarget.value.trim();
        if (!searchQuery) {
            this.setState({ customers: [] });
            return;
        };
        httpService.get(`/customers/search/${searchQuery}`).then((response: any) => {
            this.setState({ customers: response.data.data });
        }).finally(() => {

        });
    };

    setCustomer = (customer: ICustomer): void => {
        this.setState({ customer: customer });
    };

    selectCustomer(customer: ICustomer) {
        this.setState({ customer: customer });
        this.closeModal('chooseCustomerModal');
    }

    closeModal = (id: string): void => {
        const createModal = document.querySelector(`#${id}`)
        if (createModal) {
            var modalInstance = Modal.getInstance(createModal);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    };
    removeCustomer() {
        this.setState({ customer: undefined });
    }


    createCustomer = (e: React.FormEvent<HTMLFormElement>): void => {
        e.preventDefault()
        if (!this.state.customerName) {
            toast.error("Customer name is required!")
            return;
        };
        this.setState({ isLoading: true });
        httpService.post(`/customers/create-new`, {
            name: this.state.customerName,
            email: this.state.customerEmail,
            mobile: this.state.customerMobile,
        }).then((response: any) => {
            this.setCustomer(response.data.data);
            this.setState({ customerName: "" });
            this.setState({ customerEmail: "" });
            this.setState({ customerMobile: "" });
            var form = (document.getElementById("create-customer-form") as HTMLFormElement);
            if (form) {
                form.reset();
            }
            this.closeModal('createCustomerModal');
            toast.info("Customer has been created.");
        }).finally(() => {
            this.setState({ isLoading: false });
        });
    };

    handleCustomerNameChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerName: event.currentTarget.value });
    };
    handleCustomerEmailChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerEmail: event.currentTarget.value });
    };
    handleCustomerMobileChange = (event: React.FormEvent<HTMLInputElement>): void => {
        this.setState({ customerMobile: event.currentTarget.value });
    };
    printInvoice = (data: any): void => {
        var printWindow = window.open('', 'PRINT', 'height=800,width=800');
        if (!printWindow) return;
        printWindow.document.title = data.order_number;
        printWindow.document.write(`<html><head><title>Order Receipt ${data.order_number}</title>`);
        printWindow.document.write('</head><body >');
        printWindow.document.write(`<div style="margin-bottom: 1.5rem;text-align: center !important;">`);
        printWindow.document.write('<div style="font-size: 1.50rem;">The Bruvs</div>');
        printWindow.document.write(`<div style="font-size: 0.875em;">Zahlé - Baalbek Hwy, Lebanon</div>`);
        printWindow.document.write(`<div style="font-size: 0.875em;">+961 70 615 556</div>`);
        printWindow.document.write(`<div style="font-size: 0.875em;">info@the-bruvs.net</div>`);
        printWindow.document.write(`<div style="font-size: 0.875em;">www.the-bruvs.net</div>`);
        printWindow.document.write(`</div>`);

        printWindow.document.write(`<div style="text-align: center !important;margin-bottom: 0.5rem !important;">Receipt № ${data.order_number}</div>`);
        printWindow.document.write(`<div style="margin-bottom: 1.5rem;text-align: center !important;">${data.date_view}</div>`);

        printWindow.document.write(`<div style="margin-bottom: 1.5rem">`);
        this.state.cart.map((item: ICartItem) => {
            if (printWindow) {
                printWindow.document.write(`<div style="display: flex">`);
                printWindow.document.write(`<div>${item.name} (x${item.quantity}) </div>`);
                printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(item.quantity * item.price)}</div>`);
                printWindow.document.write(`</div>`);
                printWindow.document.write(`<hr/>`);
            }
        });
        printWindow.document.write(`</div>`);


        printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
        printWindow.document.write(`<div>Subtotal:</div>`);
        printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.state.subtotal)}</div>`);
        printWindow.document.write(`</div>`);
        printWindow.document.write(`<hr/>`);

        if (this.state.discount > 0) {
            printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
            printWindow.document.write(`<div>Discount:</div>`);
            printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.state.discount)}</div>`);
            printWindow.document.write(`</div>`);
            printWindow.document.write(`<hr/>`);
        }
        if (this.state.deliveryCharge > 0) {
            printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
            printWindow.document.write(`<div>Delivery Charge:</div>`);
            printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.state.deliveryCharge)}</div>`);
            printWindow.document.write(`</div>`);
            printWindow.document.write(`<hr/>`);

        }

        {/* if (this.state.tax > 0) {
            printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
            printWindow.document.write(`<div>Tax:</div>`);
            printWindow.document.write(`<div style="margin-left: auto">${this.state.tax}% (${currencyFormat(this.getTotalTax())})</div>`);
            printWindow.document.write(`</div>`);
            printWindow.document.write(`<hr/>`);
        } */}

        if (this.state.tax > 0) {
            printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
            printWindow.document.write(`<div>Tax.Amount:</div>`);
            printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.getTaxAmount())}</div>`);
            printWindow.document.write(`</div>`);
            printWindow.document.write(`<hr/>`);

            printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
            printWindow.document.write(`<div>TVA ${this.state.tax}%:</div>`);
            printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.getVat())}</div>`);
            printWindow.document.write(`</div>`);
            printWindow.document.write(`<hr/>`);
        }


        printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
        printWindow.document.write(`<div>Total:</div>`);
        printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.state.total)}</div>`);
        printWindow.document.write(`</div>`);

        if(this.state.exchangeRate > 0){
            printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
            printWindow.document.write(`<div></div>`);
            printWindow.document.write(`<div style="margin-left: auto">${usd_money_format(this.getTotalUsd())}</div>`);
            printWindow.document.write(`</div>`);
        }
      
        printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
        printWindow.document.write(`<div>Paid:</div>`);
        printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.state.tenderAmount)}</div>`);
        printWindow.document.write(`</div>`);



        
        // printWindow.document.write(`<div style="display: flex;font-weight: 700">`);
        // printWindow.document.write(`<div>Change:</div>`);
        // printWindow.document.write(`<div style="margin-left: auto">${currencyFormat(this.getChangeAmount())}</div>`);
        // printWindow.document.write(`</div>`);

        if (this.state.remarks) {
            printWindow.document.write(`<hr/>`);
            printWindow.document.write(`<div style="margin-top: 1.5rem !important;">`);
            printWindow.document.write(`<div>Remarks</div>`);
            printWindow.document.write(`<div">${this.state.remarks}</div>`);
            printWindow.document.write(`</div>`);
        }
        // printWindow.document.write(`<div style="text-align: center !important;margin-bottom: 1.5rem !important;margin-top: 1.5rem !important;">`);
        // printWindow.document.write(`${data.date_view} ${data.time_view}`);
        // printWindow.document.write(`</div>`);
        printWindow.document.write(`<div style="text-align: center !important;margin-top: 1rem !important;">`);
        printWindow.document.write(`It's a pleasure to serve you ❤️`);
        printWindow.document.write(`</div>`);

        printWindow.document.write('</body></html>');
        printWindow.document.close(); // necessary for IE >= 10
        printWindow.focus(); // necessary for IE >= 10*/
        printWindow.print();
        printWindow.close();
    };
    getVat = (): number => {
        var vat = this.state.tax || 0;
        if (vat <= 0) return 0;
        var grossAmount = (this.state.subtotal || 0) ;
        var taxAmount = this.getTaxAmount();
        return Math.round(Number(grossAmount) - Number(taxAmount)) - Number(this.state.discount);
    };

    getTaxAmount = (): number => {
        var vat = this.state.tax || 0;
        if (vat <= 0) return 0;
        var grossAmount = Number(this.state.subtotal || 0) - Number(this.state.discount);
        return Math.trunc(Number(grossAmount) / Number(Number(1) + Number(vat) / Number(100)));
    };

    render(): JSX.Element {
        return (
            <React.Fragment>
                <div className="d-flex py-3">
                    <button className="btn btn-success me-2" onClick={(event) => this.goToDashboard()}>
                        <i className="bi bi-speedometer2 fs-5 align-middle"></i> Dashboard
                    </button>
                    <button className="btn btn-danger me-2" onClick={(event) => this.reset()}>
                        <i className="bi bi-eraser-fill fs-5 align-middle"></i> Reset
                    </button>
                    <button className="btn btn-light me-2 bg-white border" data-bs-toggle="modal" data-bs-target="#chooseCustomerModal">
                        <i className="bi bi-person-circle fs-5 me-1 align-middle"></i> Customer
                    </button>
                    {
                        this.state.tables.length > 0 &&
                        <div className="dropdown">
                            <button className="btn btn-light me-2 bg-white h-100 border dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" className="me-1">
                                    <path d="M4.325 9H19.675L18.825 6H5.2ZM12 7.5ZM16.8 11H7.225L6.95 13H17.05ZM4 20 5.225 11H3Q2.5 11 2.212 10.6Q1.925 10.2 2.05 9.725L3.475 4.725Q3.575 4.4 3.825 4.2Q4.075 4 4.425 4H19.575Q19.925 4 20.175 4.2Q20.425 4.4 20.525 4.725L21.95 9.725Q22.075 10.2 21.788 10.6Q21.5 11 21 11H18.8L20 20H18L17.325 15H6.675L6 20Z" />
                                </svg>
                                {this.state.table ? this.state.table.name : "Choose Table"}
                            </button>
                            <ul className="dropdown-menu scrollable-dropdown w-100 p-0" aria-labelledby="dropdownMenuButton1">
                                {
                                    this.state.table &&
                                    <React.Fragment>
                                        <li>
                                            <div className="dropdown-item text-danger cursor-pointer py-2" onClick={() => this.handleDeselectClick()}>
                                            <i className="bi bi-trash fs-5 me-1 align-middle"></i>   Remove Table
                                            </div>
                                        </li>
                                        <li><hr className="dropdown-divider m-0" /></li>
                                    </React.Fragment>
                                }
                                {this.state.tables.map((table: ITable, index, tables) => {
                                    return (
                                        <React.Fragment>
                                            <li key={table.id}>
                                                <div className="dropdown-item cursor-pointer py-2 text-wrap" onClick={() => this.handleTableClick(table)}>
                                                    {table.name}
                                                </div>
                                            </li>
                                            {index + 1 !== tables.length &&
                                                <li><hr className="dropdown-divider m-0" /></li>
                                            }

                                        </React.Fragment>
                                    )
                                })
                                }
                            </ul>
                        </div>
                    }
                    {/* <button className="btn btn-primary ms-auto  border" onClick={(event) => this.toggleFullScreen()}>
                        {this.state.isFullScreen ?
                            <i className="bi bi-fullscreen-exit fs-5 align-middle"></i>
                            :
                            <i className="bi bi-fullscreen fs-5 align-middle"></i>
                        }
                    </button> */}
                </div>
                <div className='row'>
                    <div className='col-md-6'>
                        <div className='card w-100 card-gutter rounded-0'>
                            <div className="card-header bg-white border-bottom-0 p-0">
                                <form onSubmit={(event) => this.handleSearchSubmit(event)}>
                                    <div className="position-relative w-100">
                                        <input type="text" className="form-control form-control-lg rounded-0" name="search" id="search" autoComplete="off"
                                            placeholder="Scan barcode, search by name or SKU" style={{ paddingLeft: "2rem", }}
                                            onChange={(event) => this.handleSearchChange(event)} />
                                        <div className="position-absolute top-50 start-0 translate-middle-y p-2">
                                            <i className="bi bi-upc fs-5"></i>
                                        </div>
                                    </div>
                                </form>
                                <table className="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <td width={300} className="p-3 fw-bold">Product</td>
                                            <td width={150} className="text-center p-3 fw-bold">Quantity</td>
                                            <td width={150} className="text-center p-3 fw-bold">Total</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div className="card-body p-0 overflow-auto" id="cartItems">
                                <table className="table table-bordered mb-0">
                                    <tbody>
                                        {
                                            this.state.cart.length > 0 ?

                                                <React.Fragment>
                                                    {
                                                        this.state.cart.map((item: ICartItem) => {
                                                            return (<tr key={item.id}>
                                                                <td width={300}>
                                                                    <div className=" d-flex">
                                                                        <div className="me-2">
                                                                            <img src={item.image_url} alt="img" className="rounded-2" height={50} />
                                                                        </div>
                                                                        <div>
                                                                            <div className="fw-bold">
                                                                                {item.name}
                                                                            </div>
                                                                            <div className="fw-normal">
                                                                                {currencyFormat(item.price)}
                                                                            </div>
                                                                        </div>
                                                                        <div className="ms-auto d-flex align-items-center">
                                                                            <i className="bi bi-x-circle align-middle text-danger cursor-pointer user-select-none"
                                                                                onClick={(event) => this.removeItem(item)}></i>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                                <td width={150} className="p-0 text-center align-middle">

                                                                    <input type="number" className="form-control text-center"
                                                                        value={item.quantity} onChange={(event) => this.updateItemQuantity(event, item)} />
                                                                </td>
                                                                <td width={150} className="text-center align-middle">
                                                                    {currencyFormat(item.quantity * item.price)}
                                                                </td>
                                                            </tr>)
                                                        })
                                                    }
                                                </React.Fragment>
                                                :
                                                <React.Fragment>
                                                    <tr>
                                                        <td colSpan={3} className="p-3 text-center align-middle fs-5">
                                                            No Products added...
                                                        </td>
                                                    </tr>
                                                </React.Fragment>
                                        }

                                    </tbody>
                                </table>

                            </div>
                            <div className=" card-footer p-0 bg-white" id="orderDetails">
                                <table className="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td width={200}>
                                                Customer: {this.state.customer ? this.state.customer.name : 'N/A'}
                                                {this.state.customer &&
                                                    <div className=" float-end">
                                                        <i className="bi bi-x-circle align-middle text-danger cursor-pointer fs-7 user-select-none"
                                                            onClick={(event) => this.removeCustomer()}></i>
                                                    </div>
                                                }
                                            </td>
                                            <td width={200} className="text-end">Subtotal</td>
                                            <td width={200} className="align-middle text-center">{currencyFormat(this.state.subtotal)}</td>
                                        </tr>
                                        <tr>
                                            <td width={200} className="text-start align-middle clicable-cell"
                                                data-bs-toggle="modal" data-bs-target="#deliveryChargeModal">
                                                Delivery Charge: {this.state.deliveryCharge ? currencyFormat(this.state.deliveryCharge) : "N/A"}
                                            </td>
                                            <td width={200} className="text-end align-middle clicable-cell"
                                                data-bs-toggle="modal" data-bs-target="#discountModal">
                                                Discount
                                            </td>
                                            <td width={200} className="text-center text-danger align-middle clicable-cell"
                                                data-bs-toggle="modal" data-bs-target="#discountModal">
                                                {currencyFormat(this.state.discount)}
                                            </td>
                                        </tr>
                                        <tr className=" alert-success">
                                            <td width={200} className="text-start clicable-cell"
                                                data-bs-toggle="modal" data-bs-target="#taxModal">
                                                <div>
                                                    TAX.AMOUNT: {currencyFormat(this.getTaxAmount())}
                                                </div>
                                                <div>
                                                    TVA  {this.state.tax}%: {currencyFormat(this.getVat())}
                                                </div>
                                            </td>
                                            <td width={200} className="fw-bold text-end align-middle">Total</td>
                                            <td width={200} className="text-center align-middle fw-bold">
                                                <div>{currencyFormat(this.state.total)}</div>
                                                <div>{usd_money_format(this.getTotalUsd())}</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <button type="button" className="btn btn-success py-4 rounded-0 shadow-sm fs-3 btn-lg w-100"
                                data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                CHECKOUT
                            </button>
                        </div>
                    </div>
                    <div className='col-md-6'>
                        <div className='card w-100 card-gutter rounded-0'>

                            <div className="card-header bg-white">
                                <div className="d-flex px-0" style={{ minHeight: "calc(1.5em + 1rem + 5px)", padding: "0.5rem" }}>
                                    <a className="text-decoration-none cursor-pointer pe-2 fs-5" onClick={(event) => this.backClick()}>
                                        Categories
                                    </a>
                                    {
                                        this.state.showProducts &&
                                        <React.Fragment>
                                            <i className="bi bi-arrow-right align-middle pe-2 fs-5"></i>
                                            <span className="fw-normal text-muted pe-2 fs-5" aria-current="page">
                                                {this.state.categoryName}
                                            </span>
                                            <i className="bi bi-arrow-right align-middle pe-2 fs-5"></i>
                                        </React.Fragment>
                                    }
                                </div>
                            </div>

                            <div className='card-body overflow-auto py-0'>
                                {this.state.isLoadingCategories &&
                                    <div className="py-5">
                                        <div className="d-flex justify-content-center m-2">
                                            <div className="spinner-border text-primary" role="status" style={{ width: "4rem", height: "4rem", }}>
                                                <span className="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <div className="fw-bold h3 text-center">Loading...</div>
                                    </div>
                                }

                                {
                                    !this.state.showProducts &&
                                    <React.Fragment>
                                        {
                                            this.state.categories.length > 0 &&
                                            <div className="row">
                                                {this.state.categories.map((category: ICategory) => {
                                                    return (<div key={category.id} className="col-lg-4 col-md-4 col-sm-6 col-6 mb-0 p-0">
                                                        <div className="position-relative w-100 border cursor-pointer user-select-none"
                                                            onClick={(event) => this.categoryClick(category)}>
                                                            <picture>
                                                                <source type="image/jpg" srcSet={category.image_url} />
                                                                <img alt={category.name} src={category.image_url} aria-hidden="true"
                                                                    className="object-fit-cover h-100 w-100" />
                                                            </picture>
                                                            <div className="position-absolute bottom-0 start-0 h-100 d-flex flex-column align-items-center justify-content-center p-4 mb-0 w-100 cell-item-label text-center" >
                                                                <div className="product-name" dir="auto">{category.name}</div>
                                                            </div>
                                                        </div>

                                                    </div>);
                                                })}
                                            </div>
                                        }
                                    </React.Fragment>
                                }
                                {
                                    this.state.showProducts &&
                                    <React.Fragment>
                                        {
                                            this.state.products.length > 0 &&
                                            <div className="row overflow-auto">
                                                {this.state.products.map((product: IProduct) => {
                                                    return (<div key={product.id} className="col-lg-4 col-md-4 col-sm-6 col-6 mb-0 p-0">
                                                        <div className="position-relative w-100 border cursor-pointer user-select-none"
                                                            onClick={(event) => this.addToCart(product)}>
                                                            <picture>
                                                                <source type="image/jpg" srcSet={product.image_url} />
                                                                <img alt={product.name} src={product.image_url} aria-hidden="true"
                                                                    className="object-fit-cover h-100 w-100" />
                                                            </picture>
                                                            <div className="position-absolute bottom-0 start-0 h-100 d-flex flex-column align-items-center justify-content-center p-4 mb-0 w-100 cell-item-label text-center" >
                                                                <div>{product.name}</div>
                                                                <div className="fw-normal">{currencyFormat(product.price)}</div>
                                                            </div>
                                                        </div>

                                                    </div>);
                                                })}
                                            </div>
                                        }
                                    </React.Fragment>
                                }
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal" id="discountModal" tabIndex={-1} aria-labelledby="discountModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="discountModalLabel">
                                    Discount Percentage
                                </h5>
                                <i className="bi bi-x-circle align-middle text-black fs-4 cursor-pointer user-select-none"
                                    data-bs-dismiss="modal" aria-label="Close"></i>
                            </div>
                            <div className="modal-body">
                                <h3 className="text-center">
                                    {this.state.discountPercentage || 0}% = {currencyFormat(this.state.discount)}
                                </h3>
                                <div className="mb-3">
                                    <input type="number" className="form-control form-control-lg text-center" id="floatingInputDiscount" placeholder="Discount"
                                        value={this.state.discountPercentage}
                                        onFocus={e => e.target.select()}
                                        onChange={e => {
                                            var percentage = e.target.value;
                                            if (Number(percentage) < 0) return;
                                            if (Number(percentage) > 100) return;
                                            var percentageValue = percentage == '' ? undefined : Number(percentage);
                                            this.setState({ discountPercentage: percentageValue }, ()=>this.calculateTotal())
                                        }} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal" id="deliveryChargeModal" tabIndex={-1} aria-labelledby="deliveryChargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="deliveryChargeModalLabel">
                                    <i className="bi bi-truck me-2 align-middle text-black fs-4"></i> Delivery Charge
                                </h5>
                                <i className="bi bi-x-circle align-middle text-black fs-4 cursor-pointer user-select-none"
                                    data-bs-dismiss="modal" aria-label="Close"></i>
                            </div>
                            <div className="modal-body">
                                <h3 className="text-center">{currencyFormat(this.state.deliveryCharge)}</h3>
                                <div className="mb-3">
                                    <input type="number" className="form-control form-control-lg text-center" id="floatingInputDeliveryCharge" placeholder="Delivery Charge"
                                        value={this.state.deliveryCharge}
                                        onFocus={e => e.target.select()}
                                        onChange={e => this.setState({ deliveryCharge: Number(e.target.value) }, () => this.calculateTotal())} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal" id="taxModal" tabIndex={-1} aria-labelledby="taxModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="taxModalLabel">
                                    Tax Rate
                                </h5>
                                <i className="bi bi-x-circle align-middle text-black fs-4 cursor-pointer user-select-none"
                                    data-bs-dismiss="modal" aria-label="Close"></i>
                            </div>
                            <div className="modal-body">
                                <h3>{this.state.tax}%</h3>
                                <div className="form-floating mb-3">
                                    <input type="number" className="form-control" id="floatingInputTaxRate" placeholder="Tax Rate"
                                        value={this.state.tax}
                                        onChange={e => {
                                            let taxRate = Number(e.target.value);
                                            if (taxRate < 0) {
                                                e.target.value = "0";
                                                this.setState({ tax: 0 }, () => this.calculateTotal())

                                                return;
                                            }
                                            if (taxRate > 100) {
                                                e.target.value = "100";
                                                this.setState({ tax: 100 }, () => this.calculateTotal())
                                                return;
                                            };
                                            this.setState({ tax: taxRate }, () => this.calculateTotal())
                                        }} />
                                    <label htmlFor="floatingInputTaxRate">Tax Rate (%)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal" id="createCustomerModal" tabIndex={-1} aria-labelledby="createCustomerModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="createCustomerModalLabel">
                                    <i className="bi bi-person-circle me-2 align-middle text-black fs-4"></i> Customer
                                </h5>
                                <i className="bi bi-x-circle align-middle text-black fs-4 cursor-pointer user-select-none"
                                    data-bs-dismiss="modal" aria-label="Close"></i>
                            </div>
                            <div className="modal-body">
                                <form method="POST" onSubmit={this.createCustomer} role="form" id="create-customer-form">
                                    <div className="form-floating mb-3">
                                        <input type="text" className="form-control" id="floatingInputName" placeholder="Name"
                                            onChange={(event) => this.handleCustomerNameChange(event)} />
                                        <label htmlFor="floatingInputName">Name*</label>
                                    </div>
                                    <div className="form-floating mb-3">
                                        <input type="email" className="form-control" id="floatingInputEmail" placeholder="name@example.com"
                                            onChange={(event) => this.handleCustomerEmailChange(event)} />
                                        <label htmlFor="floatingInputEmail">Email address</label>
                                    </div>
                                    <div className="form-floating mb-3">
                                        <input type="tel" className="form-control" id="floatingInputPhone" placeholder="Phone"
                                            onChange={(event) => this.handleCustomerMobileChange(event)} />
                                        <label htmlFor="floatingInputPhone">Mobile Number</label>
                                    </div>
                                    <button className="btn btn-primary" type="submit" disabled={this.state.isLoading}>
                                        Create
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal" id="chooseCustomerModal" tabIndex={-1} aria-labelledby="chooseCustomerModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="chooseCustomerModalLabel">
                                    <i className="bi bi-person-circle me-2 align-middle text-black fs-4"></i> Select Customer
                                    <button type="button" className="btn btn-primary btn-sm mx-3" data-bs-toggle="modal"
                                        data-bs-target="#createCustomerModal">
                                        Create New
                                    </button>
                                </h5>
                                <i className="bi bi-x-circle align-middle text-black fs-4 cursor-pointer user-select-none"
                                    data-bs-dismiss="modal" aria-label="Close"></i>
                            </div>
                            <div className="modal-body p-0">
                                <div className="position-relative w-100">
                                    <input type="text" className="form-control form-control-lg rounded-0 shadow-none border-top-0 border-end-0 border-start-0"
                                        name="search" id="search" autoComplete="off"
                                        placeholder="Search by name..." style={{ paddingLeft: "2rem", }}
                                        onChange={(event) => this.handleCustomerSearchChange(event)} />
                                    <div className="position-absolute top-50 start-0 translate-middle-y p-2">
                                        <i className="bi bi-search fs-5"></i>
                                    </div>
                                </div>
                                <div className="overflow-auto" style={{ height: "250px" }}>
                                    {this.state.customers.length > 0 &&
                                        <React.Fragment>
                                            {this.state.customers.map((cuts: ICustomer) => {
                                                return (
                                                    <div className="p-3 clicable-cell" onClick={(e) => this.selectCustomer(cuts)} key={cuts.id}>
                                                        <div className="fw-bold">
                                                            {cuts.name}
                                                        </div>
                                                        {cuts.email || cuts.mobile &&
                                                            <div className="small text-muted">
                                                                {cuts.email} {cuts.mobile ? `, ${cuts.mobile}` : ''}
                                                            </div>
                                                        }
                                                    </div>
                                                );
                                            })}
                                        </React.Fragment>
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal fade" id="checkoutModal" tabIndex={-1} aria-labelledby="checkoutModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered modal-lg">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="checkoutModalLabel">

                                </h5>
                                <i className="bi bi-x-circle align-middle text-black fs-4 cursor-pointer user-select-none"
                                    data-bs-dismiss="modal" aria-label="Close"></i>
                            </div>
                            <div className="modal-body py-0">
                                <div className="row">
                                    <div className="col-6 py-3 bg-primary-sec">
                                        <table className="table table-borderless">
                                            <tbody>
                                                <tr className="fw-bold">
                                                    <td className="text-danger-sec">AMOUNT DUE</td>
                                                    <td className="text-white">{currencyFormat(this.state.total)}</td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec">Subtotal</td>
                                                    <td className="text-white">{currencyFormat(this.state.subtotal)}</td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec">NO. OF ITEMS</td>
                                                    <td className="text-white">
                                                        {this.state.cart.reduce(function (prev, current) {
                                                            return prev + + current.quantity
                                                        }, 0)}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec">TOTAL DISCOUNT</td>
                                                    <td className="text-white">{currencyFormat(this.state.discount)}</td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec">DELIVERY CHARGE</td>
                                                    <td className="text-white">{currencyFormat(this.state.deliveryCharge)}</td>
                                                </tr>
                                                {/* <tr>
                                                    <td className="text-danger-sec">TOTAL TAX</td>
                                                    <td className="text-white">{currencyFormat(this.getTotalTax())} ({this.state.tax}%)</td>
                                                </tr> */}
                                                <tr>
                                                    <td className="text-danger-sec">TAX.AMOUNT</td>
                                                    <td className="text-white">{currencyFormat(this.getTaxAmount())}</td>
                                                </tr>
                                                <tr>
                                                    <td className="text-danger-sec">TVA  {this.state.tax}%</td>
                                                    <td className="text-white">{currencyFormat(this.getVat())}</td>
                                                </tr>
                                                {this.state.table &&
                                                    <tr>
                                                        <td className="text-danger-sec">Table</td>
                                                        <td className="text-white">{this.state.table.name}</td>
                                                    </tr>

                                                }
                                                {this.state.customer &&
                                                    <React.Fragment>
                                                        <tr>
                                                            <td className="text-danger-sec align-middle">CUSTOMER</td>
                                                            <td className="text-white">
                                                                {this.state.customer.name}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td className="text-danger-sec align-middle">EMAIL</td>
                                                            <td className="text-white">
                                                                {this.state.customer.email}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td className="text-danger-sec align-middle">PHONE</td>
                                                            <td className="text-white">
                                                                {this.state.customer.mobile}
                                                            </td>
                                                        </tr>

                                                    </React.Fragment>
                                                }
                                            </tbody>
                                        </table>
                                        <hr />
                                        <div className="mb-3">
                                            <label htmlFor="remarks" className="form-label text-danger-sec">REMARKS</label>
                                            <textarea className="form-control" id="remarks" rows={3}
                                                onChange={(event) => this.handleRemarksChange(event)}>{this.state.remarks}</textarea>
                                        </div>

                                    </div>
                                    <div className="col-6 py-3 bg-light d-flex flex-column">
                                        <div className="text-center text-danger">CHECKOUT</div>
                                        <hr />
                                        <div className="mb-3">
                                            <label htmlFor="tender-amount" className="form-label">Type the tender amount</label>
                                            <input type="number" className="form-control" id="tender-amount"
                                                value={this.state.tenderAmount} onChange={(event) => this.handleTenderAmountChange(event)} />
                                        </div>
                                        <hr />
                                        <table className="table table-borderless">
                                            <tbody>
                                                <tr className="fw-bold">
                                                    <td className="text-danger-sec">
                                                        {this.getChangeAmount() < 0 ? 'Owe' : 'Change'}
                                                    </td>
                                                    <td>{currencyFormat(this.getChangeAmount())}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div className="mt-auto">
                                            <button className="btn btn-primary btn-lg w-100 disabled cursor-not-allowed mb-2">
                                                <i className="bi bi-credit-card me-2"></i>  PAY WITH CARD
                                            </button>
                                            <button className="btn btn-success btn-lg w-100"
                                                disabled={this.state.isLoading}
                                                onClick={(e) => this.storeOrder()}>
                                                <i className="bi bi-cash me-2"></i>  PAY CASH
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ToastContainer position="bottom-left"
                    autoClose={2000}
                    pauseOnHover
                    theme="colored"
                    hideProgressBar={true} />
            </React.Fragment >
        )
    }
}
export default PointOfSale;

const element = document.getElementById('pos');
if (element) {
    const props = Object.assign({}, element.dataset)
    const root = ReactDOM.createRoot(element);
    root.render(<PointOfSale tax={0} delivery={0} discount={0}  {...props} />);
}