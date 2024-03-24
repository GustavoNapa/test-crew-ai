import './bootstrap';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import focus from '@alpinejs/focus'
 

window.Alpine = Alpine;

Alpine.plugin(mask);

Alpine.plugin(focus);

Alpine.start();

// Initialization for ES Users
import {
    Modal,
    Ripple,
    initTWE,
  } from "tw-elements";
  
initTWE({ Modal, Ripple });