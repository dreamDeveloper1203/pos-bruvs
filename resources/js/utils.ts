// export function fileSize(size: number): string {
//     const i = Math.floor(Math.log(size) / Math.log(1024));
//     return (
//         (size / Math.pow(1024, i)).toFixed(2) * 1 +
//         ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
//     );
// }



export function currencyFormat(value: number): string {
    return `LL ${value.toLocaleString()}`
}
/**
 * Format number to USD Currency.
 *
 * @param {number} number.
 * @return {string} formatted number.
 */
export function usd_money_format(val: number) {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(val);
}