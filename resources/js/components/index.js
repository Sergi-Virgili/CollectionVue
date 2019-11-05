import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
// import CheckButton from './buttons/CheckButton'

import { HasError, AlertError, AlertSuccess } from 'vform'

// Components that are registered globaly.
[
  Card,
  Child,
  // CheckButton,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,

  // CollectionList
].forEach(Component => {
  Vue.component(Component.name, Component)
})
