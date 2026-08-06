import { h } from 'vue'
import checkboxChecked from '@images/svg/checkbox-checked.svg'
import checkboxIndeterminate from '@images/svg/checkbox-indeterminate.svg'
import checkboxUnchecked from '@images/svg/checkbox-unchecked.svg'
import radioChecked from '@images/svg/radio-checked.svg'
import radioUnchecked from '@images/svg/radio-unchecked.svg'

const customIcons = {
  'mdi-checkbox-blank-outline': checkboxUnchecked,
  'mdi-checkbox-marked': checkboxChecked,
  'mdi-minus-box': checkboxIndeterminate,
  'mdi-radiobox-marked': radioChecked,
  'mdi-radiobox-blank': radioUnchecked,
}

const aliases = {
  calendar: 'bi-calendar',
  collapse: 'bi-chevron-up',
  complete: 'bi-check',
  cancel: 'bi-x',
  close: 'bi-x',
  delete: 'bi-x-circle',
  clear: 'bi-x-circle',
  success: 'bi-check-circle',
  info: 'bi-info-circle',
  warning: 'bi-exclamation-triangle',
  error: 'bi-exclamation-circle',
  prev: 'bi-chevron-left',
  ratingEmpty: 'bi-star',
  ratingFull: 'bi-star-fill',
  ratingHalf: 'bi-star-half',
  next: 'bi-chevron-right',
  delimiter: 'bi-circle',
  sort: 'bi-arrow-up',
  expand: 'bi-chevron-down',
  menu: 'bi-list',
  subgroup: 'bi-caret-down-fill',
  dropdown: 'bi-chevron-down',
  edit: 'bi-pencil',
  loading: 'bi-arrow-clockwise',
  first: 'bi-chevron-double-left',
  last: 'bi-chevron-double-right',
  unfold: 'bi-arrows-expand',
  file: 'bi-paperclip',
  plus: 'bi-plus',
  minus: 'bi-dash',
  sortAsc: 'bi-arrow-up',
  sortDesc: 'bi-arrow-down',
}

export const iconify = {
  component: props => {
    const iconName = props.icon
    
    // Handle custom SVGs
    if (typeof iconName === 'string' && customIcons[iconName]) {
      return h(customIcons[iconName])
    }

    // Handle Bootstrap Icons
    if (typeof iconName === 'string' && iconName.startsWith('bi-')) {
      return h('i', {
        class: ['bi', iconName],
        style: 'font-size: inherit; color: inherit;'
      })
    }
    
    // Fallback for other icons
    return h(props.tag, {
      ...props,
      class: [iconName],
      tag: undefined,
      icon: undefined,
    })
  },
}

export const icons = {
  defaultSet: 'iconify',
  aliases,
  sets: {
    iconify,
  },
}
