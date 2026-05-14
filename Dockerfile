FROM golang:1.26-alpine AS builder
WORKDIR /app

# Копируем модули сначала
COPY go.mod go.sum ./
RUN go mod download

# Копируем код
COPY . .

# Собираем
RUN CGO_ENABLED=0 GOOS=linux go build -o /cmd ./main.go

# Финальный образ
FROM alpine:latest
RUN apk --no-cache add ca-certificates tzdata

WORKDIR /root/
COPY --from=builder /cmd .

EXPOSE 8080
CMD ["./cmd"]