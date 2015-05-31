jQuery ($)->
	ELEMENT_STATES =
		SECTION:
			COLLAPSED: 'collapsed'
			EXPANDED: 'expanded'
	DATA_KEYS =
		SECTION_STATE: 'state'
		SECTION_DEFAULT_STATE: 'default-state'
	ELEMENT_CLASSES =
		COLLAPSED: 'collapsed'
	ELEMENT_ROLES =
		SECTION_CONTROL: 'section-control'
	JQUERY_DOCUMENT = $(document)
	SELECTORS =
		SECTION: 'section'
		HEADINGS: ('h' + i for i in [1..6]).join(', ')
		SECTION_HEADINGS: ('section h' + i for i in [1..6]).join ', '
		SECTION_CONTROL: '[role="%s"]' .replace '%s', ELEMENT_ROLES.SECTION_CONTROL
		GLYPHICONS:
			SECTION_HEADING_PREFACE: '.glyphicon-menu-right'
	TIME =
		ANIMATION:
			DEFAULT: 300
	app =
		openSection: ($section, animationTime = TIME.ANIMATION.DEFAULT) ->
			$section.removeClass ELEMENT_CLASSES.COLLAPSED
			$section.children(':gt(0)').slideDown animationTime
			$section.data DATA_KEYS.SECTION_STATE, ELEMENT_STATES.SECTION.EXPANDED
		closeSection: ($section, animationTime = TIME.ANIMATION.DEFAULT) ->
			$section.addClass ELEMENT_CLASSES.COLLAPSED
			$section.children(':gt(0)').slideUp animationTime
			$section.data DATA_KEYS.SECTION_STATE, ELEMENT_STATES.SECTION.COLLAPSED
		toggleSection: ($section) ->
			if $section.data(DATA_KEYS.SECTION_STATE) == ELEMENT_STATES.SECTION.COLLAPSED
				app.openSection $section
			else
				app.closeSection $section
		init: () ->
			$(SELECTORS.SECTION).each () ->
				$this = $ this
				$heading = $this.children().eq(0).filter SELECTORS.HEADINGS
				if not $heading.find(SELECTORS.GLYPHICONS.SECTION_HEADING_PREFACE).length
					$glyph = $ '<i>', {
						'class': 'glyphicon glyphicon-menu-right control'
						role: ELEMENT_ROLES.SECTION_CONTROL
					}
					$heading.prepend ' '
					$heading.prepend $glyph
				if $this.data(DATA_KEYS.SECTION_DEFAULT_STATE) == ELEMENT_STATES.SECTION.COLLAPSED
					app.closeSection $this, 0
				else
					app.openSection $this, 0
			JQUERY_DOCUMENT.on 'click', SELECTORS.SECTION_HEADINGS, (e) ->
				e.preventDefault()
				e.stopPropagation()
				$this = $ this
				$section = $this.parents().filter(SELECTORS.SECTION).eq(0)
				if $section.length and $section.children().eq(0).is($this) # very dirty // awful line
					app.toggleSection $section

	app.init()
