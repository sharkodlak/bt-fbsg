CREATE TABLE todos (
	todo_id SERIAL
		PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	description TEXT NOT NULL,
	status VARCHAR(255) NOT NULL
		CHECK (status IN ('pending', 'completed'))
);