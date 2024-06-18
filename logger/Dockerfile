FROM python:3.11-alpine as runtime
LABEL authors="lguerra--rago"

WORKDIR /logger

COPY . .

RUN pip3 install --upgrade pip
RUN pip3 install --user poetry
ENV PATH="${PATH}:/root/.local/bin"
RUN poetry install

CMD ["poetry", "run", "uvicorn", "main:app", "--host", "0.0.0.0", "--port", "3001", "--reload", "--log-level", "debug"]