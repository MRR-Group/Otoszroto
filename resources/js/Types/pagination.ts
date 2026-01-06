export type PaginationLink = {
  active: boolean
  label: string
  url?: string
}

export type Pagination<T> = {
  data: T[]
  links: {
    first: string
    last: string
    next?: string
    prev?: string
  }
  meta: {
    current_page: number
    from: number
    last_page: number
    path: string
    per_page: number
    to: number
    total: number
    links: PaginationLink[]
  }
}