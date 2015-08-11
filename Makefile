dist: INSTALL README

INSTALL: INSTALL.html
	lynx --dump INSTALL.html > INSTALL
README: README.html
	lynx --dump README.html > README
