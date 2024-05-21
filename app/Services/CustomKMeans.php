<?php 

namespace App\Services;

class CustomKMeans
{
    private $numClusters;
    private $initialCentroids;

    public function __construct($numClusters, $initialCentroids)
    {
        $this->numClusters = $numClusters;
        $this->initialCentroids = $initialCentroids;
    }

    public function cluster(array $points)
    {
        $clusters = array_fill(0, $this->numClusters, []);
        $centroids = $this->initialCentroids;

        for ($iteration = 0; $iteration < 100; $iteration++) {
            $newClusters = array_fill(0, $this->numClusters, []);

            foreach ($points as $point) {
                $closestCentroid = $this->getClosestCentroid($point, $centroids);
                $newClusters[$closestCentroid][] = $point;
            }

            $newCentroids = $this->calculateNewCentroids($newClusters);

            if ($this->centroidsConverged($centroids, $newCentroids)) {
                break;
            }

            $centroids = $newCentroids;
        }

        $silhouetteScore = $this->calculateSilhouetteCoefficient($points, $newClusters, $centroids);
        // echo "Silhouette Coefficient: $silhouetteScore\n";
        $u = ["clusters" => $newClusters];
        $u["silhouette"] = $silhouetteScore;

        return $u;
    }

    private function getClosestCentroid(array $point, array $centroids)
    {
        $minDistance = PHP_INT_MAX;
        $closestCentroid = 0;

        foreach ($centroids as $index => $centroid) {
            $distance = $this->calculateDistance($point, $centroid);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $closestCentroid = $index;
            }
        }

        return $closestCentroid;
    }

    private function calculateDistance(array $point1, array $point2)
    {
        return sqrt(array_sum(array_map(function($a, $b) {
            return pow($a - $b, 2);
        }, $point1, $point2)));
    }

    private function calculateNewCentroids(array $clusters)
    {
        $centroids = [];

        foreach ($clusters as $cluster) {
            if (count($cluster) > 0) {
                $centroids[] = array_map(function(...$values) {
                    return array_sum($values) / count($values);
                }, ...$cluster);
            }
        }

        return $centroids;
    }

    private function centroidsConverged(array $oldCentroids, array $newCentroids)
    {
        foreach ($oldCentroids as $index => $oldCentroid) {
            if ($this->calculateDistance($oldCentroid, $newCentroids[$index]) > 0.001) {
                return false;
            }
        }

        return true;
    }

    private function calculateSilhouetteCoefficient(array $points, array $clusters, array $centroids)
    {
        $totalSilhouetteScore = 0;
        $totalPoints = 0;

        foreach ($clusters as $clusterIndex => $cluster) {
            foreach ($cluster as $point) {
                $a = $this->calculateAverageDistance($point, $cluster);
                $b = PHP_INT_MAX;

                foreach ($clusters as $otherClusterIndex => $otherCluster) {
                    if ($clusterIndex !== $otherClusterIndex) {
                        $averageDistance = $this->calculateAverageDistance($point, $otherCluster);
                        if ($averageDistance < $b) {
                            $b = $averageDistance;
                        }
                    }
                }

                $silhouetteScore = ($b - $a) / max($a, $b);
                $totalSilhouetteScore += $silhouetteScore;
                $totalPoints++;
            }
        }

        // Debugging: Print out the total silhouette score and total points
        // echo "Total Silhouette Score: $totalSilhouetteScore\n";
        // echo "Total Points: $totalPoints\n";

        return $totalPoints > 0 ? $totalSilhouetteScore / $totalPoints : 0;
    }

    private function calculateAverageDistance(array $point, array $cluster)
    {
        if (count($cluster) <= 1) {
            return 0;
        }

        $totalDistance = 0;
        foreach ($cluster as $otherPoint) {
            $totalDistance += $this->calculateDistance($point, $otherPoint);
        }

        return $totalDistance / (count($cluster) - 1);
    }
}
