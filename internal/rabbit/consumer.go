package rabbit

import (
	"encoding/json"
	"log"

	"github.com/Aplkaev/DzennTask_notification/internal/config"
	"github.com/Aplkaev/DzennTask_notification/internal/dto"
	"github.com/rabbitmq/amqp091-go"
)

type Consumer struct {
	channel *amqp091.Channel
}

func NewConsumer(cfg config.Config) (*Consumer, error) {
	conn, err := amqp091.Dial(cfg.RabbitURL)
	if err != nil {
		return nil, err
	}

	ch, err := conn.Channel()
	if err != nil {
		return nil, err
	}

	_, err = ch.QueueDeclare(
		"task_events_queue",
		true,
		false,
		false,
		false,
		nil,
	)

	if err != nil {
		return nil, err
	}

	return &Consumer{
		channel: ch,
	}, nil
}

func (c *Consumer) Consume(handler func(dto.Event)) error {
	msgs, err := c.channel.Consume(
		"task_events_queue",
		"",
		true,
		false,
		false,
		false,
		nil,
	)

	if err != nil {
		return err
	}

	forever := make(chan bool)

	go func() {
		for msg := range msgs {
			var event dto.Event

			err := json.Unmarshal(msg.Body, &event)
			if err != nil {
				log.Println(err)
				continue
			}

			handler(event)
		}
	}()

	<-forever

	return nil
}