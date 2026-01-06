export const usePlurals = (singular: string, pluralNominativ: string, pluralGenitive: string) => (value: number) => {
  value = Math.abs(value)

  if (value === 1) {
    return singular
  }

  if (value % 10 >= 2 && value % 10 <= 4 && (value % 100 < 10 || value % 100 >= 20)) {
    return pluralNominativ
  }

  return pluralGenitive
}