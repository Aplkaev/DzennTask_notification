package dto

type Event struct {
	EventID   string      `json:"event_id"`
	Type      string      `json:"type"`
	Version   int         `json:"version"`
	Payload   interface{} `json:"payload"`
}