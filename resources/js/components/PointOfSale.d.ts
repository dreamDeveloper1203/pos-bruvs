import React, { Component } from "react";
import { ICategory } from "../interfaces/category.interface";
import { IProduct } from "../interfaces/product.interface";
import 'react-toastify/dist/ReactToastify.css';
import { ICustomer } from "../interfaces/customer.interface";
import { ITable } from "../interfaces/table.interface";
interface ICartItem extends IProduct {
    quantity: number;
}
declare type Props = {
    tax: number;
    delivery: number;
    discount: number;
};
declare type State = {
    eat: string | null;
    paid: string | null;
    categories: ICategory[];
    products: IProduct[];
    customers: ICustomer[];
    customer: ICustomer | undefined;
    tables: ITable[];
    table: ITable | undefined;
    customerName: string | null;
    customerEmail: string | null;
    customerMobile: string | null;
    cart: ICartItem[];
    showProducts: boolean;
    categoryName: string | null;
    total: number;
    subtotal: number;
    tax: number;
    deliveryCharge: number;
    discount: number;
    discountPercentage: number | undefined;
    tenderAmount: number;
    searchValue: string | null;
    remarks: string | null;
    isFullScreen: boolean;
    isLoading: boolean;
    isLoadingCategories: boolean;
    exchangeRate: number;
};
declare class PointOfSale extends Component<Props, State> {
    constructor(props: Props);
    componentDidMount(): void;
    getExchangeRate: () => void;
    getCategories: () => void;
    getTables: () => void;
    handleTableClick: (table: ITable) => void;
    handleEatClick: (eat: string) => void;
    handlePaidClick: (paid: string) => void;
    handleDeselectClick: () => void;
    storeOrder: () => void;
    reset: () => void;
    resetPos: () => void;
    categoryClick: (category: ICategory) => void;
    backClick: () => void;
    updateItemQuantity: (event: React.ChangeEvent<HTMLInputElement>, item: ICartItem) => void;
    toggleFullScreen: () => void;
    goToDashboard: () => void;
    calculateTotal: () => void;
    getTotalUsd: () => number;
    getTotalTax: () => number;
    getChangeAmount: () => number;
    handleTenderAmountChange: (event: React.FormEvent<HTMLInputElement>) => void;
    handleRemarksChange: (event: React.FormEvent<HTMLTextAreaElement>) => void;
    removeItem: (item: ICartItem) => void;
    addToCart: (product: IProduct) => void;
    handleSearchSubmit: (event: React.FormEvent<HTMLFormElement>) => void;
    handleSearchChange: (event: React.FormEvent<HTMLInputElement>) => void;
    handleCustomerSearchChange: (event: React.FormEvent<HTMLInputElement>) => void;
    setCustomer: (customer: ICustomer) => void;
    selectCustomer(customer: ICustomer): void;
    closeModal: (id: string) => void;
    removeCustomer(): void;
    createCustomer: (e: React.FormEvent<HTMLFormElement>) => void;
    handleCustomerNameChange: (event: React.FormEvent<HTMLInputElement>) => void;
    handleCustomerEmailChange: (event: React.FormEvent<HTMLInputElement>) => void;
    handleCustomerMobileChange: (event: React.FormEvent<HTMLInputElement>) => void;
    printInvoice: (data: any) => void;
    getVat: () => number;
    getTaxAmount: () => number;
    render(): JSX.Element;
}
export default PointOfSale;
