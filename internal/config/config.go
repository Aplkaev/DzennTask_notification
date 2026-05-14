package config

import "os"

type Config struct {
	RabbitURL     string
	CentrifugoURL string
	CentrifugoKey string
}

func Load() Config {
	return Config{
		RabbitURL:     os.Getenv("RABBITMQ_URL"),
		CentrifugoURL: os.Getenv("CENTRIFUGO_URL"),
		CentrifugoKey: os.Getenv("CENTRIFUGO_API_KEY"),
	}
}