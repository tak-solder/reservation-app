const formatter = new Intl.NumberFormat("ja-JP");
export default formatter;

export const numberFormat: (number: number) => string = (number) => formatter.format(number);
