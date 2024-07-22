FROM postgres:latest

ENV TIMEZONE=Europe/Prague

RUN apt-get update && \
	apt-get install --no-install-recommends -y \
		gettext \
		locales \
		postgresql-contrib \
		&& \
	apt-get -qy autoremove && \
	apt-get -y clean && \
	rm -rf /var/lib/apt/lists/* && \
	rm -rf /tmp/*

RUN sed -i '/^# cs_CZ.UTF-8 /s/^# //' /etc/locale.gen && \
	locale-gen cs_CZ.UTF-8 && \
	ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime
