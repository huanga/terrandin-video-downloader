FROM php:7.2-apache

RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \    
       python \
       ffmpeg \
       locales \
    && rm -rf /var/lib/apt/lists/*

RUN curl https://storage.googleapis.com/downloads.webmproject.org/releases/webp/libwebp-1.1.0-linux-x86-64.tar.gz -O \
    && tar -xzvf ./libwebp-1.1.0-linux-x86-64.tar.gz \
    && mv ./libwebp-1.1.0-linux-x86-64/bin/* /usr/local/bin/ \
    && rm -rf ./libwebp-1.1.0-linux-x86-64

# Set the locale
RUN sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && locale-gen
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Get youtube-dl binary
ARG YTDLVERSION=latest

RUN curl -L https://yt-dl.org/downloads/${YTDLVERSION}/youtube-dl -o /usr/local/bin/youtube-dl
RUN chmod a+rx /usr/local/bin/youtube-dl

COPY . /var/www/html/
RUN chmod -R 0755 /var/www/html/
RUN mkdir /var/www/.cache/
RUN chmod -R 0777 /var/www/.cache/
WORKDIR /data/
