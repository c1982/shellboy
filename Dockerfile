FROM alpine:latest
LABEL project=shellboy
COPY ./cmd/shellboy/shellboy /bin
ENTRYPOINT ["/bin/shellboy"]