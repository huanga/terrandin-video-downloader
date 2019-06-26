# Terrandin Video Downloader

A simple video downloader UI to the popular [youtube-dl](https://ytdl-org.github.io/youtube-dl/) command, primarily focused around YouTube so I can mirror YouTube videos to Plex for my toddler, without exposing her to all of YouTube's good and bad.

## Installation

Application is published as a docker image.

```bash
docker pull huanga/terrandin-video-downloader
```

You'll need to provide a data volume (mounted in `/data`) for the downloaded materials to be accessible outside of the container. 


## Usage

```bash
docker run \
    -v /path/to/desired/download/destination:/data \
    -p 8080:80 \
    huanga/terrandin-video-downloader:latest
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
