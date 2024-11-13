
import axiosInstance from '@/axiosInstance'

export const fetchTutors = async (page = 1) => {
  try {
    const response = await axiosInstance.get(`/api/tutors?page=${page}`)
    const { data, current_page, last_page, links } = response.data.tutor_previews
    return { data, current_page, last_page, links }
  } catch (err) {
    console.error('Error fetching tutors:', err)
    throw err
  }
}

export const fetchTutorDetails = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    return response.data.tutor
  } catch (err) {
    console.error('Error fetching tutor details:', err)
    throw err
  }
}
