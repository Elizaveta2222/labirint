<?php
class PathSearch
{
    private array $matrix;
    private int $inf = PHP_INT_MAX;
    private Point $from, $to;
    function __construct($matrix, $from, $to)
    {
        $this->matrix = $matrix;
        $this->from = $from;
        $this->to = $to;
    }

    function getShortestPath(): array
    {
        // точки, по которым можно пройти
        $pointsToGo = $this->getPointsToGo();
        // ошибка, если пользователь не заполнил лабиринт
        if (empty($pointsToGo)) throw new Exception("Лабиринт не заполнен");

        // ошибка, если пользователь выбрал нулевые точки
        if (($this->matrix[$this->from->x][$this->from->y] == 0) || ($this->matrix[$this->to->x][$this->to->y] == 0))
            throw new Exception("Нельзя идти по точкам с нулевым значением");

        // массив меток кратчайших расстояний заполняется "бесконечностями"
        foreach ($pointsToGo as $point)
        {
            $d[$point->x][$point->y] = $this->inf;
        }
        // метка начальной точки
        $d[$this->from->x][$this->from->y] = $this->matrix[$this->from->x][$this->from->y];

        // текущая точка
        $y = $this->from;

        // массив пройденных точек, заносим текущую точку в пройденные
        $final[] = $y;

        while (!empty($y)) {
            $neighbors = $this->getLinks($y, $pointsToGo);
            if (!empty($neighbors)) {
                $this->UpdateDestinations($d, $pointsToGo, $neighbors, $y, $final);
                $y = $this->getMin($d, $final); // получаем следующую текущую точку
                if (!empty($y)) $final[] = $y; // если такая есть, добавляем в рассмотренные
            }
        }

        if (isset($d[$this->to->x][$this->to->y])) // если в лабиринте существует проход от входа до выхода
        {
            // текущей точкой становится выход
            $y = $this->to;
            // $path[] - массив с координатами пути
            $path[] = $y;
            while ($y != $this->from) // пока не прошли до входа
            {
                $links = $this->getBackLinks($y, $final); // находим соседа текущей точки из пройденных
                foreach ($links as $link)
                {
                    // если путь совпадает с кратчайшим, новое звено найдено
                    if ($d[$link->x][$link->y] + $pointsToGo[$y->x][$y->y] == $d[$y->x][$y->y])
                    {
                        $y = $link;
                        $path[] = $y;
                        break;
                    }
                }
            }
            return $path;
        }
        else throw new Exception("Пути от точки входа до выхода не существует");
    }

    private function getPointsToGo(): array
    {
        $pointsToGo = array();
        // ширина и высота поля
        $countX = count($this->matrix);
        $countY = count($this->matrix[0]);

        // проходим по всему полю
        for ($i = 0; $i < $countX; $i++)
        {
            for ($j = 0; $j < $countY; $j++)
            {
                if ($this->matrix[$i][$j] > 0)
                {
                    $pointsToGo[] = new Point($i, $j); // получаем все точки, по которым можно пройти
                }
            }
        }
        return $pointsToGo;
    }

    private function getBackLinks($y, $pointsToGo) : array
    {
        $links = array();
        $keyL = new Point($y->x-1, $y->y);
        $keyR = new Point($y->x+1, $y->y);
        $keyD = new Point($y->x, $y->y-1);
        $keyU = new Point($y->x, $y->y+1);
        if (in_array($keyL, $pointsToGo)) $links[] = $keyL;
        if (in_array($keyR, $pointsToGo)) $links[] = $keyR;
        if (in_array($keyD, $pointsToGo)) $links[] = $keyD;
        if (in_array($keyU, $pointsToGo)) $links[] = $keyU;
        return $links;
    }

    private function getLinks($y, $pointsToGo) : array
    {
        $neighbors = array();
        if (array_key_exists($y->x-1, $pointsToGo)) // проверка, существует ли точка
            $neighbors[] = new Point($y->x-1, $y->y);
        if (array_key_exists($y->x+1, $pointsToGo))
            $neighbors[] = new Point($y->x+1, $y->y);
        if (array_key_exists($y->y-1, $pointsToGo[$y->x]))
            $neighbors[] = new Point($y->x, $y->y-1);
        if (array_key_exists($y->y+1, $pointsToGo[$y->x]))
            $neighbors[] = new Point($y->x, $y->y+1);
        return $neighbors;
    }

    private function UpdateDestinations(&$d, $pointsToGo, $neighbors, $y, $final)
    {
        foreach ($neighbors as $neighbor) // сохраняем минимальные значения расстояния до точек, соседних с текущей
        {
            if (!in_array($neighbor, $final)) // если точка не пройдена
            {
                $temp = $d[$y->x][$y->y]+$pointsToGo[$neighbor->x][$neighbor->y];
                if ($temp < $d[$neighbor->x][$neighbor->y]) $d[$neighbor->x][$neighbor->y] = $temp;
            }
        }
    }

    private function getMin($d, array $final) // поиск пути, кратчайшего из найденных для еще не пройденной точки
    {
        $minKey = null;
        $minValue = max($d); // если не найдется пути больше самого большого
        foreach($d as $keyX => $valueX)
        {
            foreach($valueX as $keyY => $valueY)
            {
                $key = new Point($keyX, $keyY);
                if (($minValue > $valueY) && (!in_array($key, $final)))
                {
                    $minValue = $valueY;
                    $minKey = new Point($keyX, $keyY);
                }
            }
        }
        return $minKey;
    }
}