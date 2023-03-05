<?php
class PathSearch
{
    private array $matrix;
    private int $inf = PHP_INT_MAX;
    private Point $from, $to;
    function __construct($matrix, $from, $to)
    {
        $this->matrix = $matrix;
        if (!($from instanceof Point) || ($from->x > count($matrix)) || ($from->y > count($matrix[0])))
            throw new Exception("Точка входа задана некорректно");
        $this->from = $from;
        if (!($to instanceof Point) || ($to->x >= count($matrix)) || ($to->y >= count($matrix[0])))
            throw new Exception("Точка выхода задана некорректно");
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
            $links = $this->getLinks($y, $pointsToGo);
            if (!empty($links)) {
                $this->UpdateDestinations($d, $links, $y, $final);
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
                $links = $this->getLinks($y, $final); // находим соседа текущей точки из пройденных
                foreach ($links as $link)
                {
                    // если путь совпадает с кратчайшим, новое звено найдено
                    if ($d[$link->x][$link->y] + $this->matrix[$y->x][$y->y] == $d[$y->x][$y->y])
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

    private function getLinks($y, $points) : array
    {
        $links = array();
        $keyL = new Point($y->x-1, $y->y);
        $keyR = new Point($y->x+1, $y->y);
        $keyD = new Point($y->x, $y->y-1);
        $keyU = new Point($y->x, $y->y+1);
        if (in_array($keyL, $points)) $links[] = $keyL;
        if (in_array($keyR, $points)) $links[] = $keyR;
        if (in_array($keyD, $points)) $links[] = $keyD;
        if (in_array($keyU, $points)) $links[] = $keyU;
        return $links;
    }

    private function UpdateDestinations(&$d, $neighbors, $y, $final)
    {
        foreach ($neighbors as $neighbor) // сохраняем минимальные значения расстояния до точек, соседних с текущей
        {
            if (!in_array($neighbor, $final)) // если точка не пройдена
            {
                $temp = $d[$y->x][$y->y]+$this->matrix[$neighbor->x][$neighbor->y];
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