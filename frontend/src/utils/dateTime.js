// Date formatting
export const formatDate = (date) => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

// Time conversion utilities
export const parseTo12Hour = (time24h) => {
  const [hours] = time24h.split(':')
  const hour = parseInt(hours, 10)
  return { hour: hour % 12 || 12, period: hour >= 12 ? 'PM' : 'AM' }
}

export const formatTo12Hour = (timeString) => {
  if (!timeString) return null;

  const [hours, minutes] = timeString.split(':');
  let hour = parseInt(hours, 10);
  const period = hour >= 12 ? 'PM' : 'AM';

  hour = hour % 12 || 12;

  return `${hour}:${minutes} ${period}`;
}


export const convertTo24Hour = ({ hour, minute = '00', period }) => {
  let hours = hour
  if (period === 'PM' && hours < 12) hours += 12
  if (period === 'AM' && hours === 12) hours = 0
  return `${String(hours).padStart(2, '0')}:${minute}:00`
}

export const formatTimeToInteger = (timeString) => {
  if (!timeString) return null
  const [hours] = timeString.split(':')
  return parseInt(hours, 10)
}


export const formatRawDateTime = (dateString) => {
  return new Date(dateString).toISOString().slice(0, 19).replace('T', ' ')
}
