FROM php:7.2-apache

# Set Versions
ARG YTDLPVERSION=2023.07.06
ARG LIBWEBPVERSION=1.3.1
ARG ARIA2VERSION=1.36.0

RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \    
       python3 \
       python3-pip \
       ffmpeg \
       locales \
       libgmp10 \
       python3-mutagen \
       phantomjs \
       libssh2-1-dev libc-ares-dev zlib1g-dev libsqlite3-dev pkg-config libssl-dev libexpat1-dev \
    && rm -rf /var/lib/apt/lists/*

# Set the locale
RUN sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && locale-gen
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Get libwebm dependency
RUN curl https://storage.googleapis.com/downloads.webmproject.org/releases/webp/libwebp-${LIBWEBPVERSION}-linux-x86-64.tar.gz -O \
    && tar -xzvf ./libwebp-${LIBWEBPVERSION}-linux-x86-64.tar.gz \
    && mv ./libwebp-${LIBWEBPVERSION}-linux-x86-64/bin/* /usr/local/bin/ \
    && rm -rf ./libwebp-${LIBWEBPVERSION}-linux-x86-64

# Get yt-dlp
RUN curl -L https://github.com/yt-dlp/yt-dlp/releases/download/${YTDLPVERSION}/yt-dlp -o /usr/local/bin/youtube-dl \
    && chmod a+rx /usr/local/bin/youtube-dl

# Install websockets and pycryptodomex dependencies
RUN pip3 install websockets pycryptodomex

# Get aria2c dependency
RUN curl -L https://github.com/aria2/aria2/releases/download/release-${ARIA2VERSION}/aria2-${ARIA2VERSION}.tar.gz -O \
    && tar -xzvf ./aria2-${ARIA2VERSION}.tar.gz \
    && cd aria2-${ARIA2VERSION} && ./configure && make -j8 && make install \
    && rm -rf aria2-${ARIA2VERSION} aria2-${ARIA2VERSION}.tar.gz

COPY . /var/www/html/

RUN chmod -R 0755 /var/www/html/ \
    && mkdir /var/www/.cache/ \
    && chmod -R 0777 /var/www/.cache/
WORKDIR /data/
