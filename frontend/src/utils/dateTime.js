// Date formatting

// expected output: November 13, 2024, input: 2024-11-13
export const formatDate = (date) => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

// expected output: { hour: 12, period: 'PM' }, input: 12:00 PM
export const parseTo12Hour = (time24h) => {
  const [hours] = time24h.split(':')
  const hour = parseInt(hours, 10)
  return { hour: hour % 12 || 12, period: hour >= 12 ? 'PM' : 'AM' }
}

// expected output: 12:00 PM
export const formatTo12Hour = (timeString) => {
  if (!timeString) return null;

  const [hours, minutes] = timeString.split(':');
  let hour = parseInt(hours, 10);
  const period = hour >= 12 ? 'PM' : 'AM';

  hour = hour % 12 || 12;

  return `${hour}:${minutes} ${period}`;
}

// expected output: 12:00:00, input: 12:00 PM
export const convertTo24Hour = (hour, minute = '00', period) => {
  let hours = parseInt(hour, 10)
  if (period === 'PM' && hours < 12) hours += 12
  if (period === 'AM' && hours === 12) hours = 0
  return `${String(hours).padStart(2, '0')}:${minute}:00`
}

// expected output: 12, input: 12:00:00
export const formatTimeToInteger = (timeString) => {
  if (!timeString) return null
  const [hours] = timeString.split(':')
  return parseInt(hours, 10)
}

// expected output: 2024-11-13 12:00:00, input: 2024-11-13T12:00:00
export const formatRawDateTime = (dateString) => {
  return new Date(dateString).toISOString().slice(0, 19).replace('T', ' ')
}

// expected output: 1726272000000, in milliseconds
export const formatDateAndTimeToTimestamp = (date, time) => {
  return new Date(`${date.format('YYYY-MM-DD')} ${time}`).getTime();
};
