CREATE TABLE chefs (
    name            varchar(50),
    birthdate       date,
    careerInfo      varchar(400),
    PRIMARY KEY (name, birthdate)
);

CREATE TABLE recipes (
    name                   varchar(1000),
    cuisineType            varchar(50),
    instructions           varchar(60000),
    numberOfIngredients    int CHECK (numberOfIngredients > 0),
    cookTime               int,
    prepTime               int,
    servingQuantity        int,
    sourceName             varchar(100),
    type                   varchar(50),
    PRIMARY KEY (name, instructions)
);

CREATE TABLE creates (
    chefName        varchar(50),
    birthdate       date,
    recipeName      varchar(1000),
    instructions    varchar(60000),
    PRIMARY KEY (chefName, birthdate, recipeName, instructions),
    FOREIGN KEY (recipeName, instructions)
       REFERENCES recipes(name, instructions)
       ON UPDATE CASCADE,
    FOREIGN KEY (chefName, birthdate)
       REFERENCES chefs(name, birthdate)
       ON UPDATE CASCADE
);

CREATE TABLE sources (
    name                   varchar(100),
    type                   varchar(50),
    url                    varchar(1000),
    author                 varchar(50),
    pageNumber             varchar(10),
    edition                varchar(20),
    publisher              varchar(100),
    PRIMARY KEY (name, type),
    CHECK (type <> 'Website' OR url IS NOT NULL)
);

CREATE TABLE reviews (
    rating          int CHECK (rating >= 0 AND rating <= 10),
    date            date,
    comments        varchar(500),
    number          int,
    name            varchar(1000),
    instructions    varchar(60000),
    PRIMARY KEY (number, name, instructions),
    FOREIGN KEY (name, instructions)
       REFERENCES recipes(name, instructions)
       ON UPDATE CASCADE
);

CREATE TABLE tools (
    name            varchar(50),
    description     varchar(500),
    price           float,
    PRIMARY KEY (name, description)
);

CREATE TABLE requires (
    recipeName      varchar(1000),
    instructions    varchar(60000),
    toolName        varchar(50),
    description     varchar(500),
    PRIMARY KEY (recipeName, instructions, toolName, description),
    FOREIGN KEY (recipeName, instructions)
       REFERENCES recipes(name, instructions)
       ON UPDATE CASCADE,
    FOREIGN KEY (toolName, description)
       REFERENCES tools(name, description)
       ON UPDATE CASCADE
);

CREATE TABLE ingredients (
    description          varchar(500),
    name                 varchar(50),
    PRIMARY KEY (description, name)
);

CREATE TABLE usedIn (
    recipeName           varchar(1000),
    instructions         varchar(60000),
    description          varchar(500),
    ingredientName       varchar(50),
    units                varchar(15),
    amountNeeded         float,
    PRIMARY KEY (recipeName, instructions, description, ingredientName),
    FOREIGN KEY (recipeName, instructions)
       REFERENCES recipes(name, instructions)
       ON UPDATE CASCADE,
    FOREIGN KEY (description, ingredientName)
       REFERENCES ingredients(description, name)
       ON UPDATE CASCADE
);