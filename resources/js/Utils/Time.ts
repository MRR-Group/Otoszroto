import dayjs, { type Dayjs } from 'dayjs'
import { usePlurals } from '@/Utils/Plurals'
import { TimeParts } from '@/Types/time-object'

export function secondsBetween(from: string | number | Dayjs = 0, to: string | number | Dayjs = 0): number {
  return dayjs(from).diff(dayjs(to), 's')
}

export function secondsLeftTo(date: string | number | Dayjs = 0): number {
  return Math.max(secondsBetween(date, dayjs()), 0)
}

export function secondsAgo(date: string | number | Dayjs): number {
  return Math.max(dayjs().diff(dayjs(date), 's'), 0)
}

const SEC = {
  minute: 60,
  hour: 3600,
  day: 86400,
  week: 604800,
  month: 2592000,
  year: 31536000,
} as const

export function secondsToTimeParts(seconds: number): TimeParts {
  let s = Math.max(Math.floor(seconds), 0)

  const y  = Math.floor(s / SEC.year);  s -= y  * SEC.year
  const mo = Math.floor(s / SEC.month); s -= mo * SEC.month
  const w  = Math.floor(s / SEC.week);  s -= w  * SEC.week
  const d  = Math.floor(s / SEC.day);   s -= d  * SEC.day
  const h  = Math.floor(s / SEC.hour);  s -= h  * SEC.hour
  const m  = Math.floor(s / SEC.minute);s -= m  * SEC.minute

  return { y, mo, w, d, h, m, s }
}

const pluralSeconds = usePlurals('sekundę', 'sekundy', 'sekund')
const pluralMinutes = usePlurals('minutę', 'minuty', 'minut')
const pluralHours   = usePlurals('godzinę', 'godziny', 'godzin')
const pluralDays    = usePlurals('dzień', 'dni', 'dni')
const pluralWeeks   = usePlurals('tydzień', 'tygodnie', 'tygodni')
const pluralMonths  = usePlurals('miesiąc', 'miesiące', 'miesięcy')
const pluralYears   = usePlurals('rok', 'lata', 'lat')

export function timeToString(time: TimeParts): string {
  const { y, mo, w, d, s, m, h } = time

  function formatTime(h: number|undefined, m: number|undefined, s: number|undefined) {
    const hours = h ? `${h} ${pluralHours(h)}` : ''
    const minutes = m ? `${m} ${pluralMinutes(m)}` : ''
    const seconds =  s ? `${s} ${pluralSeconds(s)}` : ''

    return `${hours} ${minutes} ${seconds}`.trimStart()
  }

  if (y) {
    return `${y} ${pluralYears(y)}`
  }

  if (mo) {
    return `${mo} ${pluralMonths(mo)}`
  }

  if (w) {
    return `${w} ${pluralWeeks(w)}`
  }
  
  if (d) {
    return `${d} ${pluralDays(d)}`
  }

  if (h) {
    return formatTime(h, m, undefined)
  }

  if (m < 10) {
    return formatTime(undefined, m, s)
  }

  if (m) {
    return formatTime(undefined, m, undefined)
  }

  return formatTime(undefined, undefined, s)
}