package main

import (
	"log"

	"github.com/Aplkaev/DzennTask_notification/internal/config"
	"github.com/Aplkaev/DzennTask_notification/internal/handler"
	"github.com/Aplkaev/DzennTask_notification/internal/rabbit"
	"github.com/joho/godotenv"
	// "dzezeternal/config"
	// "notification-service/internal/rabbit"
	// "notification-service/internal/notification"
)

func main() {
	_ = godotenv.Load()

	cfg := config.Load()

	consumer, err := rabbit.NewConsumer(cfg)
	if err != nil {
		log.Fatal(err)
	}

	handler := handler.NewHandler(cfg)

	err = consumer.Consume(handler.Handle)
	if err != nil {
		log.Fatal(err)
	}
}