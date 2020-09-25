/* eslint-disable camelcase */
import Vue from 'vue'
import {
  ValidationProvider,
  ValidationObserver,
  extend,
  setInteractionMode,
} from 'vee-validate'
import { required, max, required_if } from 'vee-validate/dist/rules'

setInteractionMode('passive')

extend('required', required)
extend('max', max)
extend('required_if', required_if)

Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)
