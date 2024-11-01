<template>
  <VueCal
    :time="false"
    default-view="month"
    :cell-content="customCellContent"         
    :title-content="customTitleContent"      
    @cell-click="handleCellClick"             
  />
</template>

<script setup>
import { ref } from 'vue';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';

// Sample events to display in the calendar
const events = ref([
  { start: '2024-11-05', end: '2024-11-05', title: 'Project Deadline' },
  { start: '2024-11-15', end: '2024-11-15', title: 'Team Meeting' },
]);

// Define custom content for each cell
const customCellContent = (day) => {
  const event = events.value.find(event => event.start === day.date);
  return event
    ? `<div style="color: #2b8a3e; font-weight: bold;">📅 ${event.title}</div>`
    : `<span>${day.date.split('-')[2]}</span>`; // Default day number if no event
};

// Define custom title for each view (e.g., Month, Week)
const customTitleContent = (view) => {
  const viewName = view.activeView === 'month' ? 'Month View' : 'Other View';
  return `<span style="font-size: 1.2em; color: #005f99;">📆 ${viewName}</span>`;
};

// Navigate to a narrower view when a cell is clicked
const handleCellClick = (day, { goNarrower }) => {
  if (goNarrower) {
    goNarrower(day.date);  // Moves to the next narrower view, like month-to-week or week-to-day
  }
};
</script>

<style scoped>
/* Style for custom title and cells */
.vuecal__title-content {
  display: flex;
  align-items: center;
  justify-content: center;
}

.vuecal__cell-content {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  cursor: pointer;
}
</style>
