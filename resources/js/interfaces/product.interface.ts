export interface IProduct {
    id: string,
    name: string,
    image_url: string,
    barcode: string,
    sku: string,
    price: number,
    cost: number,
    ingredients:{
        id:number,
        master_item_id:string,
        master_item_name:string,
        unit:string,
        quantity:number,
    }[]
}