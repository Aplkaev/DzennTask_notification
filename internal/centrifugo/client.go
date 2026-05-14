package centrifugo

import (
	"context"
	"encoding/json"

	"github.com/centrifugal/gocent/v3"
)

type Client struct {
	client *gocent.Client
}

func New(url string, apiKey string) *Client {
	return &Client{
		client: gocent.New(gocent.Config{
			Addr: url,
			Key:  apiKey,
		}),
	}
}

func (c *Client) Publish(channel string, data any) error {
	payload, err := json.Marshal(data)
	if err != nil {
		return err
	}

	_, err = c.client.Publish(
		context.Background(),
		channel,
		payload,
	)
	return err
}