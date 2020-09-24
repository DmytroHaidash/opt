export default function ProductValue(
  id = null,
  unit,
  price,
  step = 1,
  min = 1,
  max = null,
  discount = null
) {
  this.id = id;
  this.unit = unit;
  this.price = price;
  this.step = step;
  this.min = min;
  this.max = max;
  this.discount = discount;
}
