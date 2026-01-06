import { Pagination } from "@/Types/pagination"
import { ButtonSmall } from "../ButtonSmall";

type Props = {
  data: Pagination<any>,
  onPageChange?: (_page: number) => void,
}

export const PaginationNav = ({data, onPageChange}: Props) => (
  <div className="flex flex-row gap-2">
    <ButtonSmall text="«" onClick={() => onPageChange?.(1)} disabled={data.meta.current_page <= 1} />
    <ButtonSmall text="‹" onClick={() => onPageChange?.(data.meta.current_page - 1)} disabled={data.meta.current_page <= 1} />
    
    <div className="text-muted flex items-center">
      Strona {data.meta.current_page} / {data.meta.last_page}
    </div>
    
    <ButtonSmall text="›" onClick={() => onPageChange?.(data.meta.current_page + 1)} disabled={data.meta.current_page >= data.meta.last_page} />
    <ButtonSmall text="»" onClick={() => onPageChange?.(data.meta.last_page)} disabled={data.meta.current_page >= data.meta.last_page} />
  </div>
);