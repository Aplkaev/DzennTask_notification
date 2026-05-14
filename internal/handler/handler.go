package handler

import (
	"log"

	"github.com/Aplkaev/DzennTask_notification/internal/config"
	"github.com/Aplkaev/DzennTask_notification/internal/centrifugo"
	"github.com/Aplkaev/DzennTask_notification/internal/dto"
)

type Handler struct {
	centrifugo *centrifugo.Client
}

func NewHandler(cfg config.Config) *Handler {
	return &Handler{
		centrifugo: centrifugo.New(
			cfg.CentrifugoURL,
			cfg.CentrifugoKey,
		),
	}
}

func (h *Handler) Handle(event dto.Event) {
	log.Println(event.Type)

	switch event.Type {

	case "task.created":
		h.centrifugo.Publish("notifications", event)

	case "task.updated":
		h.centrifugo.Publish("notifications", event)

	case "task.deleted":
		h.centrifugo.Publish("notifications", event)
	}
}