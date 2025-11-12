// Common Phosphor Icons
const phosphorIcons = [
    "ph ph-address-book", "ph ph-airplane", "ph ph-airplane-in-flight", "ph ph-airplane-landing", "ph ph-airplane-takeoff", "ph ph-airplane-tilt", "ph ph-airplay", "ph ph-alarm", "ph ph-alien", "ph ph-align-bottom", "ph ph-align-center-horizontal", "ph ph-align-center-vertical", "ph ph-align-left", "ph ph-align-right", "ph ph-align-top", "ph ph-anchor", "ph ph-anchor-simple", "ph ph-android-logo", "ph ph-angular-logo", "ph ph-aperture", "ph ph-app-store-logo", "ph ph-app-window", "ph ph-apple-logo", "ph ph-apple-podcasts-logo", "ph ph-archive", "ph ph-armchair", "ph ph-arrow-arc-left", "ph ph-arrow-arc-right", "ph ph-arrow-bend-double-up-left", "ph ph-arrow-bend-double-up-right", "ph ph-arrow-bend-down-left", "ph ph-arrow-bend-down-right", "ph ph-arrow-bend-left-down", "ph ph-arrow-bend-left-up", "ph ph-arrow-bend-right-down", "ph ph-arrow-bend-right-up", "ph ph-arrow-bend-up-left", "ph ph-arrow-bend-up-right", "ph ph-arrow-circle-down", "ph ph-arrow-circle-down-left", "ph ph-arrow-circle-down-right", "ph ph-arrow-circle-left", "ph ph-arrow-circle-right", "ph ph-arrow-circle-up", "ph ph-arrow-circle-up-left", "ph ph-arrow-circle-up-right", "ph ph-arrow-clockwise", "ph ph-arrow-counter-clockwise", "ph ph-arrow-down", "ph ph-arrow-down-left", "ph ph-arrow-down-right", "ph ph-arrow-elbow-down-left", "ph ph-arrow-elbow-down-right", "ph ph-arrow-elbow-left", "ph ph-arrow-elbow-left-down", "ph ph-arrow-elbow-left-up", "ph ph-arrow-elbow-right", "ph ph-arrow-elbow-right-down", "ph ph-arrow-elbow-right-up", "ph ph-arrow-elbow-up-left", "ph ph-arrow-elbow-up-right", "ph ph-arrow-fat-down", "ph ph-arrow-fat-left", "ph ph-arrow-fat-line-down", "ph ph-arrow-fat-line-left", "ph ph-arrow-fat-line-right", "ph ph-arrow-fat-line-up", "ph ph-arrow-fat-lines-down", "ph ph-arrow-fat-lines-left", "ph ph-arrow-fat-lines-right", "ph ph-arrow-fat-lines-up", "ph ph-arrow-fat-right", "ph ph-arrow-fat-up", "ph ph-arrow-left", "ph ph-arrow-line-down", "ph ph-arrow-line-left", "ph ph-arrow-line-right", "ph ph-arrow-line-up", "ph ph-arrow-right", "ph ph-arrow-square-down", "ph ph-arrow-square-down-left", "ph ph-arrow-square-down-right", "ph ph-arrow-square-in", "ph ph-arrow-square-left", "ph ph-arrow-square-out", "ph ph-arrow-square-right", "ph ph-arrow-square-up", "ph ph-arrow-square-up-left", "ph ph-arrow-square-up-right", "ph ph-arrow-u-down-left", "ph ph-arrow-u-down-right", "ph ph-arrow-u-left-down", "ph ph-arrow-u-left-up", "ph ph-arrow-u-right-down", "ph ph-arrow-u-right-up", "ph ph-arrow-u-up-left", "ph ph-arrow-u-up-right", "ph ph-arrow-up", "ph ph-arrow-up-left", "ph ph-arrow-up-right", "ph ph-arrows-clockwise", "ph ph-arrows-counter-clockwise", "ph ph-arrows-down-up", "ph ph-arrows-horizontal", "ph ph-arrows-in", "ph ph-arrows-in-cardinal", "ph ph-arrows-in-line-horizontal", "ph ph-arrows-in-line-vertical", "ph ph-arrows-in-simple", "ph ph-arrows-left-right", "ph ph-arrows-out", "ph ph-arrows-out-cardinal", "ph ph-arrows-out-line-horizontal", "ph ph-arrows-out-line-vertical", "ph ph-arrows-out-simple", "ph ph-arrows-vertical", "ph ph-article", "ph ph-article-medium", "ph ph-article-ny-times", "ph ph-asterisk", "ph ph-asterisk-simple", "ph ph-at", "ph ph-atom", "ph ph-baby", "ph ph-backpack", "ph ph-backspace", "ph ph-bag", "ph ph-bag-simple", "ph ph-balloon", "ph ph-bandaids", "ph ph-bank", "ph ph-barbell", "ph ph-barcode", "ph ph-barricade", "ph ph-baseball", "ph ph-baseball-cap", "ph ph-basket", "ph ph-basketball", "ph ph-bathtub", "ph ph-battery-charging", "ph ph-battery-charging-vertical", "ph ph-battery-empty", "ph ph-battery-full", "ph ph-battery-high", "ph ph-battery-low", "ph ph-battery-medium", "ph ph-battery-plus", "ph ph-battery-plus-vertical", "ph ph-battery-warning", "ph ph-battery-warning-vertical", "ph ph-bed", "ph ph-beer-bottle", "ph ph-beer-stein", "ph ph-behance-logo", "ph ph-bell", "ph ph-bell-ringing", "ph ph-bell-simple", "ph ph-bell-simple-ringing", "ph ph-bell-simple-slash", "ph ph-bell-simple-z", "ph ph-bell-slash", "ph ph-bell-z", "ph ph-bezier-curve", "ph ph-bicycle", "ph ph-binoculars", "ph ph-bird", "ph ph-bluetooth", "ph ph-bluetooth-connected", "ph ph-bluetooth-slash", "ph ph-bluetooth-x", "ph ph-boat", "ph ph-bone", "ph ph-book", "ph ph-book-bookmark", "ph ph-book-open", "ph ph-bookmark", "ph ph-bookmark-simple", "ph ph-bookmarks", "ph ph-bookmarks-simple", "ph ph-books", "ph ph-boot", "ph ph-bounding-box", "ph ph-bowl-food", "ph ph-brackets-angle", "ph ph-brackets-curly", "ph ph-brackets-round", "ph ph-brackets-square", "ph ph-brain", "ph ph-brandy", "ph ph-bridge", "ph ph-briefcase", "ph ph-briefcase-metal", "ph ph-broadcast", "ph ph-broom", "ph ph-browser", "ph ph-browsers", "ph ph-bug", "ph ph-bug-beetle", "ph ph-bug-droid", "ph ph-building", "ph ph-building-apartment", "ph ph-building-office", "ph ph-buildings", "ph ph-bulldozer", "ph ph-bus", "ph ph-butterfly", "ph ph-cactus", "ph ph-cake", "ph ph-calculator", "ph ph-calendar", "ph ph-calendar-blank", "ph ph-calendar-check", "ph ph-calendar-plus", "ph ph-calendar-x", "ph ph-camera", "ph ph-camera-plus", "ph ph-camera-rotate", "ph ph-camera-slash", "ph ph-campfire", "ph ph-car", "ph ph-car-battery", "ph ph-car-profile", "ph ph-car-simple", "ph ph-cardholder", "ph ph-cards", "ph ph-caret-circle-double-down", "ph ph-caret-circle-double-left", "ph ph-caret-circle-double-right", "ph ph-caret-circle-double-up", "ph ph-caret-circle-down", "ph ph-caret-circle-left", "ph ph-caret-circle-right", "ph ph-caret-circle-up", "ph ph-caret-double-down", "ph ph-caret-double-left", "ph ph-caret-double-right", "ph ph-caret-double-up", "ph ph-caret-down", "ph ph-caret-left", "ph ph-caret-right", "ph ph-caret-up", "ph ph-cat", "ph ph-cell-signal-full", "ph ph-cell-signal-high", "ph ph-cell-signal-low", "ph ph-cell-signal-medium", "ph ph-cell-signal-none", "ph ph-cell-signal-slash", "ph ph-cell-signal-x", "ph ph-chalkboard", "ph ph-chalkboard-simple", "ph ph-chalkboard-teacher", "ph ph-chart-bar", "ph ph-chart-bar-horizontal", "ph ph-chart-line", "ph ph-chart-line-up", "ph ph-chart-pie", "ph ph-chart-pie-slice", "ph ph-chat", "ph ph-chat-centered", "ph ph-chat-centered-dots", "ph ph-chat-centered-text", "ph ph-chat-circle", "ph ph-chat-circle-dots", "ph ph-chat-circle-text", "ph ph-chat-dots", "ph ph-chat-teardrop", "ph ph-chat-teardrop-dots", "ph ph-chat-teardrop-text", "ph ph-chat-text", "ph ph-chats", "ph ph-chats-circle", "ph ph-chats-teardrop", "ph ph-check", "ph ph-check-circle", "ph ph-check-square", "ph ph-check-square-offset", "ph ph-checkerboard", "ph ph-checks", "ph ph-chess-knight", "ph ph-chess-queen", "ph ph-chess-rook", "ph ph-chevron-circle-down", "ph ph-chevron-circle-left", "ph ph-chevron-circle-right", "ph ph-chevron-circle-up", "ph ph-chevron-double-down", "ph ph-chevron-double-left", "ph ph-chevron-double-right", "ph ph-chevron-double-up", "ph ph-chevron-down", "ph ph-chevron-left", "ph ph-chevron-right", "ph ph-chevron-up", "ph ph-circle", "ph ph-circle-dashed", "ph ph-circle-half", "ph ph-circle-half-tilt", "ph ph-circle-notch", "ph ph-circles-four", "ph ph-circles-three", "ph ph-circles-three-plus", "ph ph-circuitry", "ph ph-clipboard", "ph ph-clipboard-text", "ph ph-clock", "ph ph-clock-afternoon", "ph ph-clock-clockwise", "ph ph-clock-countdown", "ph ph-clock-counter-clockwise", "ph ph-closed-captioning", "ph ph-cloud", "ph ph-cloud-arrow-down", "ph ph-cloud-arrow-up", "ph ph-cloud-check", "ph ph-cloud-fog", "ph ph-cloud-lightning", "ph ph-cloud-moon", "ph ph-cloud-rain", "ph ph-cloud-slash", "ph ph-cloud-snow", "ph ph-cloud-sun", "ph ph-cloud-warning", "ph ph-cloud-x", "ph ph-club", "ph ph-coat-hanger", "ph ph-coda-logo", "ph ph-code", "ph ph-code-block", "ph ph-code-simple", "ph ph-codepen-logo", "ph ph-coffee", "ph ph-coin", "ph ph-coin-vertical", "ph ph-coins", "ph ph-columns", "ph ph-command", "ph ph-compass", "ph ph-compass-rose", "ph ph-computer-tower", "ph ph-confetti", "ph ph-contactless-payment", "ph ph-control", "ph ph-cookie", "ph ph-cooking-pot", "ph ph-copy", "ph ph-copy-simple", "ph ph-copyleft", "ph ph-copyright", "ph ph-corners-in", "ph ph-corners-out", "ph ph-couch", "ph ph-court-basketball", "ph ph-credit-card", "ph ph-crop", "ph ph-cross", "ph ph-crosshair", "ph ph-crosshair-simple", "ph ph-crown", "ph ph-crown-simple", "ph ph-cube", "ph ph-currency-btc", "ph ph-currency-circle-dollar", "ph ph-currency-cny", "ph ph-currency-dollar", "ph ph-currency-dollar-simple", "ph ph-currency-eth", "ph ph-currency-eur", "ph ph-currency-gbp", "ph ph-currency-inr", "ph ph-currency-jpy", "ph ph-currency-krw", "ph ph-currency-kzt", "ph ph-currency-ngn", "ph ph-currency-rub", "ph ph-cursor", "ph ph-cursor-click", "ph ph-cursor-text", "ph ph-cylinder", "ph ph-database", "ph ph-desktop", "ph ph-desktop-tower", "ph ph-detective", "ph ph-device-mobile", "ph ph-device-mobile-camera", "ph ph-device-mobile-speaker", "ph ph-device-tablet", "ph ph-device-tablet-camera", "ph ph-device-tablet-speaker", "ph ph-diamond", "ph ph-diamonds-four", "ph ph-dice-five", "ph ph-dice-four", "ph ph-dice-one", "ph ph-dice-six", "ph ph-dice-three", "ph ph-dice-two", "ph ph-disc", "ph ph-discord-logo", "ph ph-divide", "ph ph-dog", "ph ph-door", "ph ph-dots-nine", "ph ph-dots-six", "ph ph-dots-six-vertical", "ph ph-dots-three", "ph ph-dots-three-circle", "ph ph-dots-three-circle-vertical", "ph ph-dots-three-vertical", "ph ph-download", "ph ph-download-simple", "ph ph-dress", "ph ph-dribbble-logo", "ph ph-drop", "ph ph-drop-half", "ph ph-drop-half-bottom", "ph ph-dropbox-logo", "ph ph-ear", "ph ph-ear-slash", "ph ph-egg", "ph ph-egg-crack", "ph ph-eject", "ph ph-eject-simple", "ph ph-elevator", "ph ph-engine", "ph ph-envelope", "ph ph-envelope-open", "ph ph-envelope-simple", "ph ph-envelope-simple-open", "ph ph-equalizer", "ph ph-equals", "ph ph-eraser", "ph ph-exam", "ph ph-export", "ph ph-eye", "ph ph-eye-closed", "ph ph-eye-slash", "ph ph-eyedropper", "ph ph-eyedropper-sample", "ph ph-eyeglasses", "ph ph-face-mask", "ph ph-facebook-logo", "ph ph-factory", "ph ph-faders", "ph ph-faders-horizontal", "ph ph-fan", "ph ph-fast-forward", "ph ph-fast-forward-circle", "ph ph-feather", "ph ph-figma-logo", "ph ph-file", "ph ph-file-arrow-down", "ph ph-file-arrow-up", "ph ph-file-audio", "ph ph-file-cloud", "ph ph-file-code", "ph ph-file-css", "ph ph-file-csv", "ph ph-file-doc", "ph ph-file-dotted", "ph ph-file-html", "ph ph-file-image", "ph ph-file-jpg", "ph ph-file-js", "ph ph-file-jsx", "ph ph-file-lock", "ph ph-file-minus", "ph ph-file-pdf", "ph ph-file-plus", "ph ph-file-png", "ph ph-file-ppt", "ph ph-file-rs", "ph ph-file-search", "ph ph-file-text", "ph ph-file-ts", "ph ph-file-tsx", "ph ph-file-video", "ph ph-file-vue", "ph ph-file-x", "ph ph-file-xls", "ph ph-file-zip", "ph ph-files", "ph ph-film-script", "ph ph-film-slate", "ph ph-film-strip", "ph ph-fingerprint", "ph ph-fingerprint-simple", "ph ph-finn-the-human", "ph ph-fire", "ph ph-fire-simple", "ph ph-first-aid", "ph ph-first-aid-kit", "ph ph-fish", "ph ph-fish-simple", "ph ph-flag", "ph ph-flag-banner", "ph ph-flag-checkered", "ph ph-flame", "ph ph-flashlight", "ph ph-flask", "ph ph-flip-horizontal", "ph ph-flip-vertical", "ph ph-floppy-disk", "ph ph-floppy-disk-back", "ph ph-flow-arrow", "ph ph-flower", "ph ph-flower-lotus", "ph ph-flying-saucer", "ph ph-folder", "ph ph-folder-dotted", "ph ph-folder-lock", "ph ph-folder-minus", "ph ph-folder-open", "ph ph-folder-plus", "ph ph-folder-simple", "ph ph-folder-simple-dotted", "ph ph-folder-simple-lock", "ph ph-folder-simple-minus", "ph ph-folder-simple-plus", "ph ph-folder-simple-star", "ph ph-folder-simple-user", "ph ph-folder-star", "ph ph-folder-user", "ph ph-folders", "ph ph-football", "ph ph-footprints", "ph ph-fork-knife", "ph ph-frame-corners", "ph ph-framer-logo", "ph ph-function", "ph ph-funnel", "ph ph-funnel-simple", "ph ph-game-controller", "ph ph-garage", "ph ph-gas-pump", "ph ph-gauge", "ph ph-gear", "ph ph-gear-six", "ph ph-gender-female", "ph ph-gender-intersex", "ph ph-gender-male", "ph ph-gender-neuter", "ph ph-gender-nonbinary", "ph ph-gender-transgender", "ph ph-ghost", "ph ph-gif", "ph ph-gift", "ph ph-git-branch", "ph ph-git-commit", "ph ph-git-diff", "ph ph-git-fork", "ph ph-git-merge", "ph ph-git-pull-request", "ph ph-github-logo", "ph ph-gitlab-logo", "ph ph-gitlab-logo-simple", "ph ph-globe", "ph ph-globe-hemisphere-east", "ph ph-globe-hemisphere-west", "ph ph-globe-simple", "ph ph-globe-stand", "ph ph-google-chrome-logo", "ph ph-google-logo", "ph ph-google-photos-logo", "ph ph-google-play-logo", "ph ph-google-podcasts-logo", "ph ph-gradient", "ph ph-graduation-cap", "ph ph-graph", "ph ph-grid-four", "ph ph-hamburger", "ph ph-hand", "ph ph-hand-eye", "ph ph-hand-fist", "ph ph-hand-grabbing", "ph ph-hand-palm", "ph ph-hand-pointing", "ph ph-hand-soap", "ph ph-hand-wave", "ph ph-handbag", "ph ph-handbag-simple", "ph ph-hands-clapping", "ph ph-handshake", "ph ph-hard-drive", "ph ph-hard-drives", "ph ph-hash", "ph ph-hash-straight", "ph ph-headlights", "ph ph-headphones", "ph ph-headset", "ph ph-heart", "ph ph-heart-break", "ph ph-heart-straight", "ph ph-heart-straight-break", "ph ph-heartbeat", "ph ph-hexagon", "ph ph-high-heel", "ph ph-highlighter-circle", "ph ph-horse", "ph ph-hourglass", "ph ph-hourglass-high", "ph ph-hourglass-low", "ph ph-hourglass-medium", "ph ph-hourglass-simple", "ph ph-hourglass-simple-high", "ph ph-hourglass-simple-low", "ph ph-hourglass-simple-medium", "ph ph-house", "ph ph-house-line", "ph ph-house-simple", "ph ph-ice-cream", "ph ph-identification-badge", "ph ph-identification-card", "ph ph-image", "ph ph-image-square", "ph ph-images", "ph ph-infinity", "ph ph-info", "ph ph-instagram-logo", "ph ph-intersect", "ph ph-jeep", "ph ph-kanban", "ph ph-key", "ph ph-key-return", "ph ph-keyboard", "ph ph-keyhole", "ph ph-knife", "ph ph-ladder", "ph ph-ladder-simple", "ph ph-lamp", "ph ph-laptop", "ph ph-layout", "ph ph-leaf", "ph ph-lifebuoy", "ph ph-lightbulb", "ph ph-lightbulb-filament", "ph ph-lightning", "ph ph-lightning-slash", "ph ph-line-segment", "ph ph-line-segments", "ph ph-link", "ph ph-link-break", "ph ph-link-simple", "ph ph-link-simple-break", "ph ph-link-simple-horizontal", "ph ph-link-simple-horizontal-break", "ph ph-linkedin-logo", "ph ph-linux-logo", "ph ph-list", "ph ph-list-bullets", "ph ph-list-checks", "ph ph-list-dashes", "ph ph-list-heart", "ph ph-list-magnifying-glass", "ph ph-list-numbers", "ph ph-list-plus", "ph ph-list-stars", "ph ph-lock", "ph ph-lock-key", "ph ph-lock-key-open", "ph ph-lock-laminated", "ph ph-lock-laminated-open", "ph ph-lock-open", "ph ph-lock-simple", "ph ph-lock-simple-open", "ph ph-magic-wand", "ph ph-magnet", "ph ph-magnet-straight", "ph ph-magnifying-glass", "ph ph-magnifying-glass-minus", "ph ph-magnifying-glass-plus", "ph ph-map-pin", "ph ph-map-pin-line", "ph ph-map-trifold", "ph ph-markdown-logo", "ph ph-marker-circle", "ph ph-martini", "ph ph-mask-happy", "ph ph-mask-sad", "ph ph-math-operations", "ph ph-medal", "ph ph-medal-military", "ph ph-medium-logo", "ph ph-megaphone", "ph ph-megaphone-simple", "ph ph-messenger-logo", "ph ph-meta-logo", "ph ph-metronome", "ph ph-microphone", "ph ph-microphone-slash", "ph ph-microphone-stage", "ph ph-microsoft-excel-logo", "ph ph-microsoft-outlook-logo", "ph ph-microsoft-powerpoint-logo", "ph ph-microsoft-teams-logo", "ph ph-microsoft-word-logo", "ph ph-minus", "ph ph-minus-circle", "ph ph-money", "ph ph-monitor", "ph ph-monitor-play", "ph ph-moon", "ph ph-moon-stars", "ph ph-moped", "ph ph-moped-front", "ph ph-mosque", "ph ph-motorcycle", "ph ph-mountains", "ph ph-mouse", "ph ph-mouse-simple", "ph ph-music-note", "ph ph-music-note-simple", "ph ph-music-notes", "ph ph-music-notes-plus", "ph ph-music-notes-simple", "ph ph-navigation-arrow", "ph ph-needle", "ph ph-newspaper", "ph ph-newspaper-clipping", "ph ph-note", "ph ph-note-blank", "ph ph-note-pencil", "ph ph-notebook", "ph ph-notepad", "ph ph-notification", "ph ph-number-circle-eight", "ph ph-number-circle-five", "ph ph-number-circle-four", "ph ph-number-circle-nine", "ph ph-number-circle-one", "ph ph-number-circle-seven", "ph ph-number-circle-six", "ph ph-number-circle-three", "ph ph-number-circle-two", "ph ph-number-circle-zero", "ph ph-number-eight", "ph ph-number-five", "ph ph-number-four", "ph ph-number-nine", "ph ph-number-one", "ph ph-number-seven", "ph ph-number-six", "ph ph-number-square-eight", "ph ph-number-square-five", "ph ph-number-square-four", "ph ph-number-square-nine", "ph ph-number-square-one", "ph ph-number-square-seven", "ph ph-number-square-six", "ph ph-number-square-three", "ph ph-number-square-two", "ph ph-number-square-zero", "ph ph-number-three", "ph ph-number-two", "ph ph-number-zero", "ph ph-nut", "ph ph-ny-times-logo", "ph ph-octagon", "ph ph-option", "ph ph-orange-slice", "ph ph-package", "ph ph-paint-brush", "ph ph-paint-brush-broad", "ph ph-paint-brush-household", "ph ph-paint-bucket", "ph ph-paint-roller", "ph ph-palette", "ph ph-paper-plane", "ph ph-paper-plane-right", "ph ph-paper-plane-tilt", "ph ph-paperclip", "ph ph-paperclip-horizontal", "ph ph-parachute", "ph ph-paragraph", "ph ph-parallelogram", "ph ph-park", "ph ph-password", "ph ph-path", "ph ph-patreon-logo", "ph ph-pause", "ph ph-pause-circle", "ph ph-paw-print", "ph ph-peace", "ph ph-pen", "ph ph-pen-nib", "ph ph-pen-nib-straight", "ph ph-pencil", "ph ph-pencil-circle", "ph ph-pencil-line", "ph ph-pencil-simple", "ph ph-pencil-simple-line", "ph ph-pencil-simple-slash", "ph ph-pencil-slash", "ph ph-percent", "ph ph-person", "ph ph-person-simple", "ph ph-person-simple-run", "ph ph-person-simple-walk", "ph ph-perspective", "ph ph-phone", "ph ph-phone-call", "ph ph-phone-disconnect", "ph ph-phone-incoming", "ph ph-phone-outgoing", "ph ph-phone-plus", "ph ph-phone-slash", "ph ph-phone-x", "ph ph-phosphor-logo", "ph ph-piano-keys", "ph ph-picture-in-picture", "ph ph-piggy-bank", "ph ph-pill", "ph ph-pinterest-logo", "ph ph-pinwheel", "ph ph-pizza", "ph ph-placeholder", "ph ph-planet", "ph ph-play", "ph ph-play-circle", "ph ph-playlist", "ph ph-plug", "ph ph-plugs", "ph ph-plugs-connected", "ph ph-plus", "ph ph-plus-circle", "ph ph-plus-minus", "ph ph-poker-chip", "ph ph-police-car", "ph ph-polygon", "ph ph-popcorn", "ph ph-potted-plant", "ph ph-power", "ph ph-prescription", "ph ph-presentation", "ph ph-presentation-chart", "ph ph-printer", "ph ph-prohibit", "ph ph-prohibit-inset", "ph ph-projector-screen", "ph ph-projector-screen-chart", "ph ph-push-pin", "ph ph-push-pin-simple", "ph ph-push-pin-simple-slash", "ph ph-push-pin-slash", "ph ph-puzzle-piece", "ph ph-qr-code", "ph ph-question", "ph ph-queue", "ph ph-quotes", "ph ph-radical", "ph ph-radio", "ph ph-radio-button", "ph ph-rainbow", "ph ph-rainbow-cloud", "ph ph-read-cv-logo", "ph ph-receipt", "ph ph-receipt-x", "ph ph-record", "ph ph-rectangle", "ph ph-recycle", "ph ph-reddit-logo", "ph ph-repeat", "ph ph-repeat-once", "ph ph-rewind", "ph ph-rewind-circle", "ph ph-robot", "ph ph-rocket", "ph ph-rocket-launch", "ph ph-rows", "ph ph-rss", "ph ph-rss-simple", "ph ph-rug", "ph ph-ruler", "ph ph-scales", "ph ph-scan", "ph ph-scissors", "ph ph-scooter", "ph ph-screencast", "ph ph-scribble-loop", "ph ph-scroll", "ph ph-selection", "ph ph-selection-all", "ph ph-selection-background", "ph ph-selection-foreground", "ph ph-selection-inverse", "ph ph-selection-plus", "ph ph-selection-slash", "ph ph-share", "ph ph-share-network", "ph ph-shield", "ph ph-shield-check", "ph ph-shield-checkered", "ph ph-shield-chevron", "ph ph-shield-plus", "ph ph-shield-slash", "ph ph-shield-star", "ph ph-shield-warning", "ph ph-shipping-container", "ph ph-shirt-folded", "ph ph-shooting-star", "ph ph-shopping-bag", "ph ph-shopping-bag-open", "ph ph-shopping-cart", "ph ph-shopping-cart-simple", "ph ph-shower", "ph ph-shuffle", "ph ph-shuffle-angular", "ph ph-shuffle-simple", "ph ph-sidebar", "ph ph-sidebar-simple", "ph ph-sign-in", "ph ph-sign-out", "ph ph-signpost", "ph ph-sim-card", "ph ph-siren", "ph ph-sketch-logo", "ph ph-skip-back", "ph ph-skip-back-circle", "ph ph-skip-forward", "ph ph-skip-forward-circle", "ph ph-skull", "ph ph-slack-logo", "ph ph-sliders", "ph ph-sliders-horizontal", "ph ph-slideshow", "ph ph-smiley", "ph ph-smiley-blank", "ph ph-smiley-meh", "ph ph-smiley-nervous", "ph ph-smiley-sad", "ph ph-smiley-sticker", "ph ph-smiley-wink", "ph ph-smiley-x-eyes", "ph ph-snapchat-logo", "ph ph-snowflake", "ph ph-soccer-ball", "ph ph-sort-ascending", "ph ph-sort-descending", "ph ph-soundcloud-logo", "ph ph-spade", "ph ph-sparkle", "ph ph-speaker-high", "ph ph-speaker-low", "ph ph-speaker-none", "ph ph-speaker-simple-high", "ph ph-speaker-simple-low", "ph ph-speaker-simple-none", "ph ph-speaker-simple-slash", "ph ph-speaker-simple-x", "ph ph-speaker-slash", "ph ph-speaker-x", "ph ph-spinner", "ph ph-spinner-gap", "ph ph-spiral", "ph ph-spotify-logo", "ph ph-square", "ph ph-square-half", "ph ph-square-half-bottom", "ph ph-square-logo", "ph ph-square-split-horizontal", "ph ph-square-split-vertical", "ph ph-squares-four", "ph ph-stack", "ph ph-stack-overflow-logo", "ph ph-stack-simple", "ph ph-stamp", "ph ph-star", "ph ph-star-four", "ph ph-star-half", "ph ph-star-of-david", "ph ph-steering-wheel", "ph ph-steps", "ph ph-stethoscope", "ph ph-sticker", "ph ph-stool", "ph ph-stop", "ph ph-stop-circle", "ph ph-storefront", "ph ph-strategy", "ph ph-stripe-logo", "ph ph-student", "ph ph-subtract", "ph ph-subtract-square", "ph ph-suitcase", "ph ph-suitcase-simple", "ph ph-sun", "ph ph-sun-dim", "ph ph-sun-horizon", "ph ph-sunglasses", "ph ph-swap", "ph ph-swatches", "ph ph-swimming-pool", "ph ph-sword", "ph ph-synagogue", "ph ph-syringe", "ph ph-table", "ph ph-tabs", "ph ph-tag", "ph ph-tag-chevron", "ph ph-tag-simple", "ph ph-target", "ph ph-taxi", "ph ph-telegram-logo", "ph ph-television", "ph ph-television-simple", "ph ph-tennis-ball", "ph ph-tent", "ph ph-terminal", "ph ph-terminal-window", "ph ph-test-tube", "ph ph-text-aa", "ph ph-text-align-center", "ph ph-text-align-justify", "ph ph-text-align-left", "ph ph-text-align-right", "ph ph-text-b", "ph ph-text-columns", "ph ph-text-h", "ph ph-text-h-five", "ph ph-text-h-four", "ph ph-text-h-one", "ph ph-text-h-six", "ph ph-text-h-three", "ph ph-text-h-two", "ph ph-text-indent", "ph ph-text-italic", "ph ph-text-outdent", "ph ph-text-strikethrough", "ph ph-text-subscript", "ph ph-text-superscript", "ph ph-text-t", "ph ph-text-underline", "ph ph-textbox", "ph ph-thermometer", "ph ph-thermometer-cold", "ph ph-thermometer-hot", "ph ph-thermometer-simple", "ph ph-thumbs-down", "ph ph-thumbs-up", "ph ph-ticket", "ph ph-tidal-logo", "ph ph-tiktok-logo", "ph ph-timer", "ph ph-tip-jar", "ph ph-tire", "ph ph-toggle-left", "ph ph-toggle-right", "ph ph-toilet", "ph ph-toilet-paper", "ph ph-toolbox", "ph ph-tooth", "ph ph-tote", "ph ph-tote-simple", "ph ph-trademark", "ph ph-trademark-registered", "ph ph-traffic-cone", "ph ph-traffic-sign", "ph ph-traffic-signal", "ph ph-train", "ph ph-train-regional", "ph ph-train-simple", "ph ph-translate", "ph ph-trash", "ph ph-trash-simple", "ph ph-tray", "ph ph-tree", "ph ph-tree-evergreen", "ph ph-tree-palm", "ph ph-tree-structure", "ph ph-trend-down", "ph ph-trend-up", "ph ph-triangle", "ph ph-triangle-dashed", "ph ph-trophy", "ph ph-truck", "ph ph-twitch-logo", "ph ph-twitter-logo", "ph ph-umbrella", "ph ph-umbrella-simple", "ph ph-upload", "ph ph-upload-simple", "ph ph-usb", "ph ph-user", "ph ph-user-check", "ph ph-user-circle", "ph ph-user-circle-gear", "ph ph-user-circle-minus", "ph ph-user-circle-plus", "ph ph-user-focus", "ph ph-user-gear", "ph ph-user-list", "ph ph-user-minus", "ph ph-user-plus", "ph ph-user-rectangle", "ph ph-user-sound", "ph ph-user-square", "ph ph-user-switch", "ph ph-users", "ph ph-users-four", "ph ph-users-three", "ph ph-van", "ph ph-vault", "ph ph-vector-three", "ph ph-vector-two", "ph ph-vibrate", "ph ph-video-camera", "ph ph-video-camera-slash", "ph ph-vignette", "ph ph-voicemail", "ph ph-volleyball", "ph ph-wall", "ph ph-wallet", "ph ph-warehouse", "ph ph-warning", "ph ph-warning-circle", "ph ph-warning-octagon", "ph ph-watch", "ph ph-wave-sawtooth", "ph ph-wave-sine", "ph ph-wave-square", "ph ph-wave-triangle", "ph ph-waves", "ph ph-webcam", "ph ph-webcam-slash", "ph ph-webhooks-logo", "ph ph-wechat-logo", "ph ph-whatsapp-logo", "ph ph-wheelchair", "ph ph-wheelchair-motion", "ph ph-wifi-high", "ph ph-wifi-low", "ph ph-wifi-medium", "ph ph-wifi-none", "ph ph-wifi-slash", "ph ph-wifi-x", "ph ph-wind", "ph ph-windows-logo", "ph ph-wine", "ph ph-wrench", "ph ph-x", "ph ph-x-circle", "ph ph-x-square", "ph ph-yin-yang", "ph ph-youtube-logo"
];

// Populate the icon picker
function populateIcons(iconsToShow = phosphorIcons) {
    $('.icon-picker-icons').empty();
    
    iconsToShow.forEach(iconClass => {
        const iconItem = $('<div>')
            .addClass('icon-item')
            .attr('data-icon', iconClass)
            .html(`<i class="${iconClass} icon-preview"></i>`);

        $('.icon-picker-icons').append(iconItem);
    });
}


function getCSRFToken() {
    return $('meta[name="csrf-token"]').attr('content');
}

function getBasepath() {
    const basePath = $('a.basePath').attr('href').split('/')[1];
    const href = location.href.split('/');
    return basePath ? `${href[0]}//${href[2]}/${basePath}` : `${href[0]}//${href[2]}`;
}

function sweetAlertConfirm(confirmCallback, title, text, confirmButtonText, cancelButtonText) {
    Swal.fire({
        title: title == undefined || title == null ? 'Are you sure?' : title,
        text: text == undefined || text == null ? "You won't be able to revert this!" : text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmButtonText == undefined || confirmButtonText == null ? 'Yes, proceed!' : confirmButtonText,
        cancelButtonText: cancelButtonText == undefined || cancelButtonText == null ? 'No, cancel!' : cancelButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            if (confirmCallback != undefined && confirmCallback != null) {
                confirmCallback();
            }
        }
    });
}

// Helper function to extract configuration from data attributes
function getFilePondConfig($element) {
    var config = {};
    
    // Multiple files configuration
    if ($element.data('multiple-upload') !== undefined) {
        config.allowMultiple = $element.data('multiple-upload') === 'Y';
        config.chunkUploads = $element.data('multiple-upload') === 'Y';
    }
    
    // Max files
    if ($element.data('max-files') !== undefined) {
        config.maxFiles = $element.data('max-files');
    }
    
    // File size
    if ($element.data('max-file-size') !== undefined) {
        config.maxFileSize = $element.data('max-file-size');
    }
    
    // Accepted file types
    if ($element.data('accepted-file-types') !== undefined) {
        let fileTypes = $element.data('accepted-file-types');
        console.log('Raw file types data:', fileTypes);
        console.log('Type of fileTypes:', typeof fileTypes);
        
        if (typeof fileTypes === 'string') {
            try {
                fileTypes = fileTypes.replace(/'/g, '"');
                config.acceptedFileTypes = JSON.parse(fileTypes);
            } catch (e) {
                console.log('JSON parse failed, trying comma separation');
                config.acceptedFileTypes = fileTypes.split(',').map(item => item.trim());
            }
        } else {
            config.acceptedFileTypes = fileTypes;
        }
    }
    
    // Instant upload
    if ($element.data('instant-upload') !== undefined) {
        config.instantUpload = $element.data('instant-upload') === 'true';
    }
    
    // Image editing features
    if ($element.data('allow-image-edit') !== undefined) {
        config.allowImageEdit = $element.data('allow-image-edit');
        config.allowImagePreview = $element.data('allow-image-preview');
        config.allowImageCrop = $element.data('allow-image-crop');
        config.allowImageResize = $element.data('allow-image-resize');
        config.allowImageTransform = $element.data('allow-image-transform');
        config.allowImageExifOrientation = $element.data('allow-image-exif-orientation');
    }
    
    // Image resize dimensions
    if ($element.data('image-resize-target-width') !== undefined) {
        config.imageResizeTargetWidth = $element.data('image-resize-target-width');
    }
    
    if ($element.data('image-resize-target-height') !== undefined) {
        config.imageResizeTargetHeight = $element.data('image-resize-target-height');
    }
    
    // Image crop aspect ratio
    if ($element.data('image-crop-aspect-ratio') !== undefined) {
        config.imageCropAspectRatio = $element.data('image-crop-aspect-ratio');
    }
    
    // Image quality and format
    if ($element.data('image-transform-output-quality') !== undefined) {
        config.imageTransformOutputQuality = $element.data('image-transform-output-quality');
    }
    
    if ($element.data('image-transform-output-mime-type') !== undefined) {
        config.imageTransformOutputMimeType = $element.data('image-transform-output-mime-type');
    }
    
    // File metadata
    if ($element.data('file-metadata') !== undefined) {
        config.allowFileMetadata = true;
        config.fileMetadataObject = $element.data('file-metadata');
    }
    
    return config;
}


function disableBtn(btnClasses) {
    $.each(btnClasses, function (i, btn) {
        $('.' + btn).attr('disabled', 'true');
    });
}

function hideBtn(btnClasses) {
    $.each(btnClasses, function (i, btn) {
        $('.' + btn).addClass('d-none');
    });
}

function showBtn(btnClasses) {
    $.each(btnClasses, function (i, btn) {
        $('.' + btn).removeClass('d-none');
    });
}

function enableBtn(btnClasses) {
    $.each(btnClasses, function (i, btn) {
        $('.' + btn).removeAttr('disabled');
    });
}

function showProgress(colorClass, title) {
    $('#progress').show();

    if (title != undefined && title != null) {
        $('.porogress-text').html(title);
    }

    if (colorClass != undefined && colorClass != null && colorClass != '') {
        $('#progress #progressBar').addClass(colorClass);
    }
}

function updateProgress(percentage, colorClass) {
    if (percentage > 100) percentage = 100;
    $('#progress #progressBar').css('width', percentage + '%').text(percentage.toFixed(2) + '%');

    if (colorClass != undefined && colorClass != null && colorClass != '') {
        $('#progress #progressBar').addClass(colorClass);
    }
}

function hideProgress(restalso) {
    $('#progress').hide();
    if (restalso != undefined && restalso != null && restalso == true) {
        resetProgressBar();
    }
}

function resetProgressBar() {
    $('#progress #progressBar').css('width', '0%').text('0%');
    $('#progress #progressBar').removeClass('bg-success');
    $('#progress #progressBar').removeClass('bg-warning');
    $('#progress #progressBar').removeClass('bg-danger');
}



// Toaster message
function showMessage(type, message, timeout) {
    if (!type || !message) return;

    if (timeout == undefined || timeout == "") timeout = 2500;
    toastr.options.timeOut = timeout;

    toastr[type](message);
}




/**
 * Loading mask object
 * function1 : show  -- Show loading mask
 * function2 : hide  -- Hide loading mask
 */
var loadingMask2 = {
    show: function () {
        $("div#loadingmask2, div.loadingdots, div#loadingdots").removeClass("nodisplay");
    },
    hide: function () {
        $("div#loadingmask2, div.loadingdots, div#loadingdots").addClass("nodisplay");
    },
};


function sectionReloadAjaxReq(section, callback, disableloadingmaskeffect) {
    if (disableloadingmaskeffect == undefined || disableloadingmaskeffect == null || disableloadingmaskeffect == false) loadingMask2.show();

    $.ajax({
        url: section.url,
        type: "GET",
        success: function (data) {
            if (disableloadingmaskeffect == undefined || disableloadingmaskeffect == null || disableloadingmaskeffect == false) loadingMask2.hide();
            $("." + section.id).html("");
            $("." + section.id).append(data.page);

            if (callback) callback(data);
        },
        error: function (jqXHR, status, errorThrown) {
            if (disableloadingmaskeffect == undefined || disableloadingmaskeffect == null || disableloadingmaskeffect == false) loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        },
    });
}

function sectionReloadAjaxPostReq(section, data, callback) {
    loadingMask2.show();
    $.ajax({
        url: section.url,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: data,
        success: function (data) {
            loadingMask2.hide();
            $("." + section.id).html("");
            $("." + section.id).append(data);

            if (callback) callback();
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        },
    });
}

function sectionReloadAjaxDeleteReq(section, data, callbackFunction) {
    loadingMask2.show();
    $.ajax({
        url: section.url,
        type: "DELETE",
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: data,
        success: function (data) {
            loadingMask2.hide();
            $("." + section.id).html("");
            $("." + section.id).append(data);

            if (callbackFunction != undefined) {
                callbackFunction();
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        },
    });
}

function submitMainForm(customurl, customform, callbackFunction, callbackFunctionIfSuccess, callbackFunctionIfError) {
    if ((customform == undefined || customform == null) && $('form#mainform').length < 1) return;

    var targettedForm = customform == undefined || customform == null ? $('form#mainform') : customform;
    if (!targettedForm.smkValidate()) return;

    var submitUrl = (customurl == undefined || customurl == null) ? targettedForm.attr('action') : customurl;
    var submitType = targettedForm.attr('method');
    var formData = $(targettedForm).serializeArray();
    var enctype = targettedForm.attr('enctype');
    if (enctype == 'multipart/form-data') {
        submitMultipartForm(submitUrl, submitType, targettedForm, false);
        return;
    }

    loadingMask2.show();
    $.ajax({
        url: submitUrl,
        type: submitType,
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: formData,
        success: function (data, status, xhr) {
            loadingMask2.hide();

            // For file download
            if (data.fileDownload == true) {
                if ("application/octet-stream" == data.mediaType.type + '/' + data.mediaType.subtype) {
                    var blob = new Blob([data.file], {
                        type: data.mediaType.type + '/' + data.mediaType.subtype
                    });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = data.fileName;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    showMessage(data.status.toLowerCase(), data.message);
                    return;
                }
            }

            if (data.status == 'SUCCESS') {
                if (data.displayMessage == true) showMessage(data.status.toLowerCase(), data.message);

                if (data.triggermodalurl) {
                    modalLoader(getBasepath() + data.triggermodalurl, data.modalid);
                } else {
                    if (data.reloadsections != undefined && data.reloadsections.length > 0) {
                        $.each(data.reloadsections, function (ind, section) {
                            if (section.postData.length > 0) {
                                var data = {};
                                $.each(section.postData, function (pi, pdata) {
                                    data[pdata.key] = pdata.value;
                                })
                                sectionReloadAjaxPostReq(section, data);
                            } else {
                                sectionReloadAjaxReq(section);
                            }
                        });
                    } else if (data.reloadurl) {
                        doSectionReloadWithNewData(data);
                    } else if (data.redirecturl) {
                        setTimeout(() => {
                            window.location.replace(getBasepath() + data.redirecturl);
                        }, 1000);
                    }
                }

                if (callbackFunctionIfSuccess != undefined && callbackFunctionIfSuccess != null) {
                    callbackFunctionIfSuccess();
                }
            } else {
                if (data.displayErrorDetailModal) {
                    $('#errorDetailModal').modal('show');

                    sectionReloadAjaxReq({
                        id: data.reloadelementid,
                        url: data.reloadurl,
                    });
                }

                if (data.status) showMessage(data.status.toLowerCase(), data.message);

                if (callbackFunctionIfError != undefined && callbackFunctionIfError != null) {
                    callbackFunctionIfError();
                }
            }

            if (callbackFunction != undefined && callbackFunction != null) {
                callbackFunction();
            }

            if (data.printReport) {
                generateOnScreenReport(getBasepath() + data.printUrl, data.printParams);
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        }
    });
}

function submitMultipartForm(submitUrl, submitType, targettedForm, frommodal) {
    var files = $('#fileuploader').get(0).files;

    var formData = new FormData();
    if (files.length == 1) {
        formData.append("file", files[0]);
    }
    for (var x = 0; x < files.length; x++) {
        formData.append("files[]", files[x]);
    }

    $.each($(targettedForm).serializeArray(), function (i, b) {
        formData.append(b.name, b.value);
    })

    loadingMask2.show();
    $.ajax({
        url: submitUrl,
        type: submitType,
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: formData,
        async: false,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
            loadingMask2.hide();

            if (data.status == 'SUCCESS') {
                if (data.displayMessage == true) showMessage(data.status.toLowerCase(), data.message);

                if (data.triggermodalurl) {
                    modalLoader(getBasepath() + data.triggermodalurl, data.modalid);
                } else {
                    if (data.reloadsections != undefined && data.reloadsections.length > 0) {
                        $.each(data.reloadsections, function (ind, section) {
                            if (section.postData.length > 0) {
                                var data = {};
                                $.each(section.postData, function (pi, pdata) {
                                    data[pdata.key] = pdata.value;
                                })
                                sectionReloadAjaxPostReq(section, data);
                            } else {
                                sectionReloadAjaxReq(section);
                            }
                        });
                    } else if (data.reloadurl) {
                        doSectionReloadWithNewData(data);
                    } else if (data.redirecturl) {
                        setTimeout(() => {
                            window.location.replace(getBasepath() + data.redirecturl);
                        }, 1000);
                    }
                }
            } else {
                if (data.displayErrorDetailModal) {
                    $('#errorDetailModal').modal('show');

                    sectionReloadAjaxReq({
                        id: data.reloadelementid,
                        url: data.reloadurl,
                    });
                }

                showMessage(data.status.toLowerCase(), data.message);
            }

            if (data.printReport) {
                generateOnScreenReport(getBasepath() + data.printUrl, data.printParams);
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        }
    });
}


function deleteRequest(customurl, data, callbackFunction, callbackFunctionIfSuccess, callbackFunctionIfError) {
    loadingMask2.show();
    $.ajax({
        url: customurl,
        type: 'DELETE',
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: data,
        success: function (data) {
            loadingMask2.hide();
            if (data.status == 'SUCCESS') {
                if (data.displayMessage == true) showMessage(data.status.toLowerCase(), data.message);

                if (callbackFunctionIfSuccess != undefined && callbackFunctionIfSuccess != null) {
                    callbackFunctionIfSuccess();
                }

                if (data.triggermodalurl) {
                    modalLoader(getBasepath() + data.triggermodalurl, data.modalid);
                } else {
                    if (data.reloadsections != undefined && data.reloadsections.length > 0) {
                        $.each(data.reloadsections, function (ind, section) {
                            if (section.postData.length > 0) {
                                var data = {};
                                $.each(section.postData, function (pi, pdata) {
                                    data[pdata.key] = pdata.value;
                                })
                                sectionReloadAjaxPostReq(section, data);
                            } else {
                                sectionReloadAjaxReq(section);
                            }
                        });
                    } else if (data.reloadurl) {
                        doSectionReloadWithNewData(data);
                    } else if (data.redirecturl) {
                        setTimeout(() => {
                            window.location.replace(getBasepath() + data.redirecturl);
                        }, 1000);
                    }
                }
            } else {
                if (data.displayErrorDetailModal) {
                    $('#errorDetailModal').modal('show');

                    sectionReloadAjaxReq({
                        id: data.reloadelementid,
                        url: data.reloadurl,
                    });
                }

                showMessage(data.status.toLowerCase(), data.message);
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        }
    });
}



function actionPostRequest(customurl, data, timeout, callbackFunction, callbackFunctionIfSuccess, callbackFunctionIfError) {
    loadingMask2.show();
    $.ajax({
        url: customurl,
        type: 'POST',
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: data,
        success: function (data) {
            loadingMask2.hide();
            if (data.status == 'SUCCESS') {
                if (data.displayMessage == true) showMessage(data.status.toLowerCase(), data.message);

                if (callbackFunctionIfSuccess != undefined && callbackFunctionIfSuccess != null) {
                    callbackFunctionIfSuccess();
                }

                if (data.triggermodalurl) {
                    modalLoader(getBasepath() + data.triggermodalurl, data.modalid);
                } else {
                    if (data.reloadsections != undefined && data.reloadsections.length > 0) {
                        $.each(data.reloadsections, function (ind, section) {
                            if (section.postData.length > 0) {
                                var data = {};
                                $.each(section.postData, function (pi, pdata) {
                                    data[pdata.key] = pdata.value;
                                })
                                sectionReloadAjaxPostReq(section, data);
                            } else {
                                sectionReloadAjaxReq(section);
                            }
                        });
                    } else if (data.reloadurl) {
                        doSectionReloadWithNewData(data);
                    } else if (data.redirecturl) {
                        setTimeout(() => {
                            window.location.replace(getBasepath() + data.redirecturl);
                        }, 1000);
                    }
                }
            } else {
                if (data.displayErrorDetailModal) {
                    $('#errorDetailModal').modal('show');

                    sectionReloadAjaxReq({
                        id: data.reloadelementid,
                        url: data.reloadurl,
                    });
                }

                if (timeout == undefined || timeout == null) timeout = 2000;
                showMessage(data.status.toLowerCase(), data.message, timeout);
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        }
    });
}


function generateOnScreenReport(customurl, data, reportType) {
    if (reportType == undefined || reportType == '') reportType = "PDF";
    data.onScreenReport = true;

    loadingMask2.show();
    $.ajax({
        url: customurl,
        type: 'POST',
        data: data,
        success: function (data) {
            loadingMask2.hide();
            var arrrayBuffer = base64ToArrayBuffer(data);
            if ("PDF" == reportType) {
                var blob = new Blob([arrrayBuffer], {
                    type: "application/pdf"
                });
                var link = window.URL.createObjectURL(blob);
                window.open(link, '', 'height=650,width=840');
            } else {
                var blob = new Blob([arrrayBuffer], {
                    type: "application/octetstream"
                });
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, reportName + ".xls");
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = $("<a />");
                    a.attr("download", reportName + ".xls");
                    a.attr("href", link);
                    $("body").append(a);
                    a[0].click();
                    $(a, "body").remove();
                }
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        }
    });
}


function validateAndSubmitReportForm(customvalidateUrl) {
    if ($('form#reportform').length < 1) return;

    var targettedForm = $('form#reportform');
    if (!targettedForm.smkValidate()) return;

    var validateUrl = (customvalidateUrl != undefined) ? customvalidateUrl : $(targettedForm).data('validate-url');
    var submitType = targettedForm.attr('method');
    var formData = $(targettedForm).serializeArray();

    // check validation first
    loadingMask2.show();
    $.ajax({
        url: validateUrl,
        type: submitType,
        data: formData,
        success: function (data) {
            loadingMask2.hide();
            if (data.status == 'SUCCESS') {
                if (data.displayMessage == true) showMessage(data.status.toLowerCase(), data.message);
                submitReportForm(null, data.rparam);
            } else {
                showMessage(data.status.toLowerCase(), data.message);
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        }
    });

}


/**
 * Submit Report form
 * @param customurl
 * @param rParam Replacable Param or Addition Param
 * @returns
 */
function submitReportForm(customurl, rParam) {
    if ($('form#reportform').length < 1) return;

    var targettedForm = $('form#reportform');
    if (!targettedForm.smkValidate()) return;

    var submitUrl = (customurl != undefined && customurl != null) ? customurl : targettedForm.attr('action');
    var submitType = targettedForm.attr('method');
    var formData = $(targettedForm).serializeArray();

    // New or updatable params should add here
    if (rParam != undefined && rParam != null) {
        $.each(rParam, function (key, value) {
            var fieldExists = false;

            // Check if the field already exists in formData
            formData.forEach(function (field) {
                if (field.name === key) {
                    field.value = value; // Update the existing field
                    fieldExists = true;
                }
            });

            // If the field doesn't exist, add it
            if (!fieldExists) {
                formData.push({
                    name: key,
                    value: value
                });
            }
        });
    }

    var reportType = $('#reportType').val();
    if (reportType == undefined || reportType == '') reportType = "PDF";
    var reportName = $('#reportName').val() != '' ? $('#reportName').val() : 'report';

    loadingMask2.show();
    $.ajax({
        url: submitUrl,
        type: submitType,
        data: formData,
        success: function (data) {
            loadingMask2.hide();
            var arrrayBuffer = base64ToArrayBuffer(data);
            if ("PDF" == reportType) {
                var blob = new Blob([arrrayBuffer], {
                    type: "application/pdf"
                });
                var link = window.URL.createObjectURL(blob);
                window.open(link, '', 'height=650,width=840');
            } else {
                var blob = new Blob([arrrayBuffer], {
                    type: "application/octetstream"
                });
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, reportName + ".xls");
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = $("<a />");
                    a.attr("download", reportName + ".xls");
                    a.attr("href", link);
                    $("body").append(a);
                    a[0].click();
                    $(a, "body").remove();
                }
            }
        },
        error: function (jqXHR, status, errorThrown) {
            loadingMask2.hide();
            if (jqXHR.status === 401) {
                // Session is invalid, reload the url to go back to login page
                location.reload();
            } else {
                showMessage("error", jqXHR.responseJSON.message);
            }
        }
    });
}

/**
 * Convert Base64 string to array buffer
 * @param base64
 * @returns
 */
function base64ToArrayBuffer(base64) {
    var binaryString = window.atob(base64);
    var binaryLen = binaryString.length;
    var bytes = new Uint8Array(binaryLen);
    for (var i = 0; i < binaryLen; i++) {
        var ascii = binaryString.charCodeAt(i);
        bytes[i] = ascii;
    }
    return bytes;
}



// Summernote Send uploaded file to server
function sendSummernoteFile(file, el) {
    var formData = new FormData();
    formData.append("file", file);

    loadingMask2.show();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: formData,
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        enctype: "multipart/form-data",
        url: $(".media-store-url").attr("href"),
        success: function (data) {
            loadingMask2.hide();
            var url = getBasepath() + data.mediafile;
            $(el).summernote("editor.insertImage", url);
        },
        error: function (e) {
            loadingMask2.hide();
            console.log(e);
        },
    });
}
