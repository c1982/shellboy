FROM alpine:latest
LABEL project=shellboy
COPY ./cmd/shellboy /bin/shellboy
ENTRYPOINT ["/bin/shellboy"]