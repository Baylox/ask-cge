// Assets/app.js
import { Application } from '@hotwired/stimulus'
import { definitionsFromContext } from 'stimulus-vite-helpers'
import Turbo from '@hotwired/turbo'

// Enable Turbo (replaces traditional redirects)
Turbo.start()

// Stimulus
const application = Application.start()
const context = require.context('./controllers', true, /\.js$/)
application.load(definitionsFromContext(context))

import './app.css'; 