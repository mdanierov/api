<?php

namespace DMirzorasul\Api\Env;

class Env
{
    public const VAR_NAME_REGEX = '(?i:_?[A-Z][A-Z0-9_]*+)';

    private array $values = [];

    /**
     * @throws \Exception
     */
    public function __construct(
        private readonly string $path
    ) {
        $this->load();
    }

    /**
     * @throws \Exception
     */
    public function load(): void
    {
        if (!is_readable($this->path) || is_dir($this->path)) {
            // TODO: Add Exception
            throw new \Exception('Path is wrong!!!  --- ' . $this->path);
        }

        $data = file_get_contents($this->path);
        if (str_starts_with($data, "\xEF\xBB\xBF")) {
            // TODO: Add Exception
            throw new \Exception('Loading files starting with a byte-order-mark (BOM) is not supported.');
        }

        $data   = str_replace([ "\r\n", "\r" ], "\n", $data);
        $cursor = 0;
        $end    = strlen($data);
        if (preg_match('/(?:\s*+(?:#[^\n]*+)?+)++/A', $data, $match, 0, $cursor)) {
            $cursor = strlen($match[0]);
        }

        while ($cursor < $end) {
            if (!preg_match('/(export[ \t]++)?(' . self::VAR_NAME_REGEX . ')/A', $data, $matches, 0, $cursor)) {
                // TODO: Add Exception
                throw new \Exception('Invalid character in variable name');
            }

            $cursor += strlen($matches[0]);

            if ($cursor === $end || "\n" === $data[$cursor] || '#' === $data[$cursor]) {
                if ($matches[1]) {
                    // TODO: Add Exception
                    throw new \Exception('Unable to unset an environment variable');
                }

                // TODO: Add Exception
                throw new \Exception('Missing = in the environment variable declaration');
            }

            if (' ' === $data[$cursor] || "\t" === $data[$cursor]) {
                // TODO: Add Exception
                throw new \Exception('Whitespace characters are not supported after the variable name');
            }

            if ('=' !== $data[$cursor]) {
                // TODO: Add Exception
                throw new \Exception('Missing = in the environment variable declaration');
            }

            $cursor++;
            $value = '';

            while ($cursor < $end && $data[$cursor] !== "\n" && $data[$cursor] !== "\t") {
                $value .= $data[$cursor++];
            }

            $this->set($matches[2], $value);
            if (preg_match('/(?:\s*+(?:#[^\n]*+)?+)++/A', $data, $match, 0, $cursor)) {
                $cursor += strlen($match[0]);
            }
        }
    }

    public function get(string $name): mixed
    {
        return $this->values[$name];
    }

    public function set(string $name, mixed $value): void
    {
        $this->values[$name] = $value;
    }

    public function getString(string $name): string
    {
        $value = $this->get($name);
        if (!is_string($value)) {
            // TODO: Add Exception
            throw new \Exception("$name is not found or not string");
        }

        return $value;
    }
}