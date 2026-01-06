import { Title } from "@/Components/Title";
import { Report } from "@/Types/report";

type Props = {
  report: Report,
}

export function ShowReport({report}: Props) {
  return (
    <div className='w-full p-4 mt-5 mx-auto md:px-10'>
      <Title type='h2'>Szczegóły zgłoszenia</Title>

      <div><strong>ID:</strong> {report.id}</div>
      <div><strong>Reporter:</strong> {report.reporter?.email || "N/A"}</div>
      <div><strong>Auction:</strong> {report.auction?.name || "N/A"}</div>
      <div><strong>Reason:</strong> {report.reason || "Brak"}</div>
      <div><strong>Resolved At:</strong> {report.resolvedAt || "Nie rozwiązano"}</div>
      <div><strong>Created At:</strong> {report.createdAt}</div>
      <div><strong>Updated At:</strong> {report.updatedAt}</div>
    </div>
  );
}
